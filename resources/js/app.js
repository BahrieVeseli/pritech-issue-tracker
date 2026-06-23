const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

const debounce = (callback, delay = 300) => {
    let timeoutId;

    return (...args) => {
        window.clearTimeout(timeoutId);
        timeoutId = window.setTimeout(() => callback(...args), delay);
    };
};

async function requestJson(url, options = {}) {
    const response = await fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            ...(options.headers ?? {}),
        },
        ...options,
    });

    if (!response.ok) {
        const error = new Error('Request failed');
        error.response = response;
        error.body = await response.json().catch(() => ({}));
        throw error;
    }

    return response.json();
}

function wireIssueSearch() {
    const form = document.querySelector('[data-issue-filter-form]');
    if (!form) {
        return;
    }

    const scope = document.querySelector('[data-issue-search-url]');
    const searchUrl = scope?.dataset.issueSearchUrl;
    const target = document.querySelector('[data-issues-results]');
    const filters = {
        search: document.querySelector('#issue-search'),
        status: document.querySelector('#issue-status'),
        priority: document.querySelector('#issue-priority'),
        tag: document.querySelector('#issue-tag'),
    };

    if (!searchUrl || !target) {
        return;
    }

    const loadIssues = debounce(async () => {
        const url = new URL(searchUrl, window.location.origin);
        Object.entries(filters).forEach(([key, element]) => {
            const value = element?.value?.trim();
            if (value) {
                url.searchParams.set(key, value);
            }
        });
        url.searchParams.set('ajax', '1');

        const data = await requestJson(url.toString());
        target.innerHTML = data.html;
    }, 300);

    Object.values(filters).forEach((element) => {
        element?.addEventListener('input', () => {
            loadIssues();
        });
        element?.addEventListener('change', () => {
            loadIssues();
        });
    });
}

function wireAjaxToggleButtons() {
    document.addEventListener('click', async (event) => {
        const button = event.target.closest('[data-ajax-toggle]');
        if (!button) {
            return;
        }

        event.preventDefault();

        const url = button.dataset.url;
        const method = button.dataset.method ?? 'POST';
        const target = document.querySelector(button.dataset.target);

        try {
            const data = await requestJson(url, { method });
            if (target) {
                target.innerHTML = data.html;
            }
        } catch (error) {
            console.error(error);
        }
    });
}

function wireDeleteConfirmModal() {
    const modal = document.querySelector('#delete-confirm-modal');
    const title = document.querySelector('[data-delete-modal-title]');
    const message = document.querySelector('[data-delete-modal-message]');
    const confirmButton = document.querySelector('[data-delete-modal-confirm]');
    const cancelButton = document.querySelector('[data-delete-modal-cancel]');
    let pendingForm = null;

    if (!modal || !title || !message || !confirmButton || !cancelButton) {
        return;
    }

    const openModal = (form) => {
        pendingForm = form;
        const customMessage = form.dataset.deleteMessage || 'Are you sure you want to delete this item?';
        const [headline, detail] = customMessage.split('? ');
        if (detail) {
            title.textContent = `${headline || 'Delete item'}?`;
            message.textContent = detail.trim();
        } else {
            title.textContent = 'Delete item?';
            message.textContent = customMessage;
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };

    const closeModal = () => {
        pendingForm = null;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    };

    document.addEventListener('submit', (event) => {
        const form = event.target.closest('form[data-confirm-delete]');
        if (!form) {
            return;
        }

        event.preventDefault();
        openModal(form);
    });

    confirmButton.addEventListener('click', () => {
        if (pendingForm) {
            pendingForm.submit();
        }
        closeModal();
    });

    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });
}

function wireIssueTagManager() {
    const select = document.querySelector('[data-issue-tag-manager-select]');
    const container = document.querySelector('[data-issue-tag-manager-target]');

    if (!select || !container) {
        return;
    }

    const template = select.dataset.managerUrlTemplate;
    if (!template) {
        return;
    }

    const loadManager = async () => {
        const issueId = select.value;
        if (!issueId) {
            container.innerHTML = '<p class="text-sm text-slate-500">No issues available.</p>';
            return;
        }

        const url = template.replace('__ISSUE__', issueId);
        const data = await requestJson(url);
        container.innerHTML = data.html;
    };

    select.addEventListener('change', loadManager);
}

function wireComments() {
    const scope = document.querySelector('[data-comments-url]');
    if (!scope) {
        return;
    }

    const commentsUrl = scope.dataset.commentsUrl;
    const storeUrl = scope.dataset.commentStoreUrl;
    const list = document.querySelector('[data-comments-list]');
    const loadMoreButton = document.querySelector('[data-comments-load-more]');
    const form = document.querySelector('[data-comment-form]');
    const errors = document.querySelector('[data-comment-errors]');
    let nextPageUrl = commentsUrl;

    const renderComments = async (url, append = false) => {
        if (!url) {
            return;
        }

        const data = await requestJson(url);
        if (append) {
            list.insertAdjacentHTML('beforeend', data.html);
        } else {
            list.innerHTML = data.html;
        }
        nextPageUrl = data.next_page;
        if (loadMoreButton) {
            loadMoreButton.hidden = !data.has_more;
        }
    };

    renderComments(commentsUrl);

    loadMoreButton?.addEventListener('click', () => {
        if (nextPageUrl) {
            renderComments(nextPageUrl, true);
        }
    });

    form?.addEventListener('submit', async (event) => {
        event.preventDefault();
        errors.innerHTML = '';

        try {
            const formData = new FormData(form);
            const data = await requestJson(storeUrl, {
                method: 'POST',
                body: formData,
            });

            list.insertAdjacentHTML('afterbegin', data.html);
            form.reset();
        } catch (error) {
            if (error.response?.status === 422) {
                const messages = Object.values(error.body.errors ?? {}).flat();
                errors.innerHTML = messages.map((message) => `<p class="text-sm text-red-600">${message}</p>`).join('');
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    wireIssueSearch();
    wireAjaxToggleButtons();
    wireDeleteConfirmModal();
    wireIssueTagManager();
    wireComments();
});
