/**
 * Global Site Media Gallery & Asset Picker Engine
 * Integrates with Admin CMS to allow one-click image browsing, selection, preview, and upload.
 */
(function() {
    'use strict';

    let allMediaImages = [];
    let activeSelection = null;
    let currentCallback = null;
    let currentClearCallback = null;
    let isDataLoaded = false;
    let mediaModalInstance = null;

    // DOM Elements Cache
    let modalEl, gridEl, loaderEl, emptyEl, searchInput, folderFilter, sortSelect;
    let inspectorContent, inspectorEmpty, inspectorPreview, inspectorName, inspectorFolder, inspectorDims, inspectorSize, inspectorDate, inspectorPath, copyPathBtn, previewLink, deleteBtn;
    let insertBtn, clearBtn, totalCountSpan, currentSelectionBadge;
    let dropZone, fileInput, progressBar, progressBox, progressText;

    function initDOMElements() {
        modalEl = document.getElementById('globalMediaPickerModal');
        if (!modalEl) return false;

        gridEl = document.getElementById('mediaGrid');
        loaderEl = document.getElementById('mediaGridLoader');
        emptyEl = document.getElementById('mediaGridEmpty');
        searchInput = document.getElementById('mediaSearchInput');
        folderFilter = document.getElementById('mediaFolderFilter');
        sortSelect = document.getElementById('mediaSortSelect');

        inspectorContent = document.getElementById('mediaInspectorContent');
        inspectorEmpty = document.getElementById('mediaInspectorEmpty');
        inspectorPreview = document.getElementById('inspectorImgPreview');
        inspectorName = document.getElementById('inspectorImgName');
        inspectorFolder = document.getElementById('inspectorImgFolder');
        inspectorDims = document.getElementById('inspectorImgDims');
        inspectorSize = document.getElementById('inspectorImgSize');
        inspectorDate = document.getElementById('inspectorImgDate');
        inspectorPath = document.getElementById('inspectorImgPath');
        copyPathBtn = document.getElementById('copyPathBtn');
        previewLink = document.getElementById('inspectorPreviewLink');
        deleteBtn = document.getElementById('inspectorDeleteBtn');

        insertBtn = document.getElementById('mediaPickerInsertBtn');
        clearBtn = document.getElementById('mediaPickerClearBtn');
        totalCountSpan = document.getElementById('mediaTotalCount');
        currentSelectionBadge = document.getElementById('mediaFooterCurrentSelection');

        dropZone = document.getElementById('mediaDropZone');
        fileInput = document.getElementById('mediaFileInput');
        progressBar = document.getElementById('mediaUploadProgressBar');
        progressBox = document.getElementById('mediaUploadProgressBox');
        progressText = document.getElementById('mediaUploadProgressText');

        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            mediaModalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
        }

        bindEvents();
        return true;
    }

    function bindEvents() {
        // Search & Filter
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                const clearBtn = document.getElementById('mediaSearchClear');
                if (clearBtn) clearBtn.style.display = searchInput.value ? 'block' : 'none';
                renderGallery();
            });
        }
        const searchClearBtn = document.getElementById('mediaSearchClear');
        if (searchClearBtn) {
            searchClearBtn.addEventListener('click', () => {
                searchInput.value = '';
                searchClearBtn.style.display = 'none';
                renderGallery();
            });
        }

        if (folderFilter) folderFilter.addEventListener('change', renderGallery);
        if (sortSelect) sortSelect.addEventListener('change', renderGallery);
        
        const refreshBtn = document.getElementById('mediaRefreshBtn');
        if (refreshBtn) refreshBtn.addEventListener('click', () => fetchMediaLibrary(true));

        // Copy Relative Path in Sidebar
        if (copyPathBtn) {
            copyPathBtn.addEventListener('click', () => {
                if (inspectorPath && inspectorPath.value) {
                    navigator.clipboard.writeText(inspectorPath.value).then(() => {
                        const icon = copyPathBtn.querySelector('i');
                        if (icon) icon.className = 'fas fa-check text-success';
                        setTimeout(() => {
                            if (icon) icon.className = 'fas fa-copy';
                        }, 1800);
                    });
                }
            });
        }

        // Delete from Server
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                if (!activeSelection) return;
                if (!confirm(`Are you sure you want to permanently delete "${activeSelection.name}"?`)) return;

                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('file', activeSelection.path);

                fetch('media_api.php', { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            allMediaImages = allMediaImages.filter(img => img.path !== activeSelection.path);
                            activeSelection = null;
                            updateInspector();
                            renderGallery();
                        } else {
                            alert(data.message || 'Failed to delete file.');
                        }
                    })
                    .catch(err => {
                        console.error('Delete error:', err);
                        alert('Server communication error.');
                    });
            });
        }

        // Insert / Choose Selection
        if (insertBtn) {
            insertBtn.addEventListener('click', () => {
                if (activeSelection && typeof currentCallback === 'function') {
                    currentCallback(activeSelection);
                }
                if (mediaModalInstance) mediaModalInstance.hide();
            });
        }

        // Remove / Clear Selection
        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (typeof currentClearCallback === 'function') {
                    currentClearCallback();
                }
                if (mediaModalInstance) mediaModalInstance.hide();
            });
        }

        // Drag & Drop Upload
        if (dropZone) {
            ['dragenter', 'dragover'].forEach(evtName => {
                dropZone.addEventListener(evtName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(evtName => {
                dropZone.addEventListener(evtName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropZone.classList.remove('dragover');
                });
            });

            dropZone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files.length) handleFileUpload(files);
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', () => {
                if (fileInput.files && fileInput.files.length) {
                    handleFileUpload(fileInput.files);
                }
            });
        }
    }

    /**
     * Upload Image(s) via AJAX
     */
    function handleFileUpload(files) {
        if (!files || !files.length) return;

        const formData = new FormData();
        formData.append('action', 'upload');
        for (let i = 0; i < files.length; i++) {
            formData.append('media_files[]', files[i]);
        }

        if (progressBox) progressBox.classList.remove('d-none');
        if (progressBar) progressBar.style.width = '20%';
        if (progressText) progressText.innerText = `Uploading ${files.length} file(s)...`;

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'media_api.php', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable && progressBar) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
            }
        };

        xhr.onload = function() {
            if (progressBox) progressBox.classList.add('d-none');
            if (fileInput) fileInput.value = '';

            try {
                const res = JSON.parse(xhr.responseText);
                if (res.success && res.uploaded && res.uploaded.length) {
                    // Prepend newly uploaded files to array
                    res.uploaded.forEach(item => {
                        allMediaImages.unshift(item);
                    });
                    
                    // Auto-select the first uploaded file
                    activeSelection = res.uploaded[0];
                    
                    // Switch back to gallery tab
                    const galleryTabBtn = document.getElementById('tab-gallery-btn');
                    if (galleryTabBtn) {
                        const tab = new bootstrap.Tab(galleryTabBtn);
                        tab.show();
                    }

                    renderGallery();
                    updateInspector();
                } else {
                    alert(res.message || 'Upload failed.');
                }
            } catch (err) {
                console.error('Upload parse error:', err);
                alert('Server returned an unexpected response.');
            }
        };

        xhr.onerror = function() {
            if (progressBox) progressBox.classList.add('d-none');
            alert('Upload network error.');
        };

        xhr.send(formData);
    }

    /**
     * Fetch media gallery items from API
     */
    function fetchMediaLibrary(forceRefresh = false) {
        if (isDataLoaded && !forceRefresh) {
            renderGallery();
            return;
        }

        if (loaderEl) loaderEl.classList.remove('d-none');
        if (gridEl) gridEl.innerHTML = '';
        if (emptyEl) emptyEl.classList.add('d-none');

        fetch('media_api.php?action=list')
            .then(res => res.json())
            .then(data => {
                if (loaderEl) loaderEl.classList.add('d-none');
                if (data.success && Array.isArray(data.images)) {
                    allMediaImages = data.images;
                    isDataLoaded = true;

                    // Populate folders dropdown
                    if (folderFilter && data.folders) {
                        folderFilter.innerHTML = '<option value="">📁 All Website Folders (All Images)</option>';
                        Object.keys(data.folders).forEach(k => {
                            const opt = document.createElement('option');
                            opt.value = k;
                            opt.textContent = '📁 ' + data.folders[k];
                            folderFilter.appendChild(opt);
                        });
                    }

                    renderGallery();
                } else {
                    if (emptyEl) emptyEl.classList.remove('d-none');
                }
            })
            .catch(err => {
                console.error('Media fetch error:', err);
                if (loaderEl) loaderEl.classList.add('d-none');
                if (emptyEl) emptyEl.classList.remove('d-none');
            });
    }

    /**
     * Filter, sort and render images in gallery grid
     */
    function renderGallery() {
        if (!gridEl) return;

        const q = (searchInput ? searchInput.value.trim().toLowerCase() : '');
        const folder = (folderFilter ? folderFilter.value : '');
        const sort = (sortSelect ? sortSelect.value : 'newest');

        let filtered = allMediaImages.filter(img => {
            const matchQ = !q || img.name.toLowerCase().includes(q) || img.path.toLowerCase().includes(q) || img.folder.toLowerCase().includes(q);
            const matchFolder = !folder || img.folder_key === folder;
            return matchQ && matchFolder;
        });

        // Sort
        filtered.sort((a, b) => {
            if (sort === 'newest') return b.mtime - a.mtime;
            if (sort === 'oldest') return a.mtime - b.mtime;
            if (sort === 'name_asc') return a.name.localeCompare(b.name);
            if (sort === 'size_desc') return b.bytes - a.bytes;
            return 0;
        });

        if (totalCountSpan) totalCountSpan.innerText = filtered.length;

        if (filtered.length === 0) {
            gridEl.innerHTML = '';
            if (emptyEl) emptyEl.classList.remove('d-none');
            return;
        }

        if (emptyEl) emptyEl.classList.add('d-none');

        // Build HTML for images
        let html = '';
        filtered.forEach(img => {
            const isSelected = activeSelection && (activeSelection.path === img.path || activeSelection.id === img.id);
            const selectedClass = isSelected ? 'selected' : '';

            html += `
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <div class="card h-100 p-1 rounded-3 media-card-item ${selectedClass}" data-path="${img.path}" data-id="${img.id}">
                    <span class="selection-badge"><i class="fas fa-check"></i></span>
                    <div class="ratio ratio-1x1 rounded-2 overflow-hidden bg-white border d-flex align-items-center justify-content-center position-relative">
                        <img src="${img.url}" alt="${img.name}" class="w-100 h-100 object-fit-contain p-1" loading="lazy">
                        <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-1 px-1 py-0" style="font-size: 0.65rem;">
                            ${img.dimensions}
                        </span>
                    </div>
                    <div class="p-1 text-truncate" title="${img.name}">
                        <span class="d-block text-truncate text-navy" style="font-size: 0.75rem; font-weight: 600;">${img.name}</span>
                        <span class="text-muted d-block" style="font-size: 0.68rem;">${img.size} • ${img.folder}</span>
                    </div>
                </div>
            </div>
            `;
        });

        gridEl.innerHTML = html;

        // Add Click & Double Click Listeners
        gridEl.querySelectorAll('.media-card-item').forEach(card => {
            const path = card.getAttribute('data-path');
            const imgData = allMediaImages.find(x => x.path === path);

            card.addEventListener('click', () => {
                gridEl.querySelectorAll('.media-card-item').forEach(c => c.classList.remove('selected'));
                card.classList.add('selected');
                activeSelection = imgData;
                updateInspector();
            });

            card.addEventListener('dblclick', () => {
                activeSelection = imgData;
                updateInspector();
                if (insertBtn) insertBtn.click();
            });
        });
    }

    /**
     * Update Inspector sidebar details
     */
    function updateInspector() {
        if (!activeSelection) {
            if (inspectorContent) inspectorContent.classList.add('d-none');
            if (inspectorEmpty) inspectorEmpty.classList.remove('d-none');
            if (insertBtn) insertBtn.disabled = true;
            if (currentSelectionBadge) currentSelectionBadge.innerText = 'None selected';
            return;
        }

        if (inspectorEmpty) inspectorEmpty.classList.add('d-none');
        if (inspectorContent) inspectorContent.classList.remove('d-none');

        if (inspectorPreview) inspectorPreview.src = activeSelection.url;
        if (inspectorName) inspectorName.innerText = activeSelection.name;
        if (inspectorFolder) inspectorFolder.innerText = activeSelection.folder;
        if (inspectorDims) inspectorDims.innerText = activeSelection.dimensions;
        if (inspectorSize) inspectorSize.innerText = activeSelection.size;
        if (inspectorDate) inspectorDate.innerText = activeSelection.date;
        if (inspectorPath) inspectorPath.value = activeSelection.path;
        if (previewLink) previewLink.href = activeSelection.url;

        if (insertBtn) insertBtn.disabled = false;
        if (currentSelectionBadge) currentSelectionBadge.innerText = activeSelection.path;
    }

    /**
     * Public API: Open Global Media Picker Modal
     */
    window.openMediaPicker = function(options = {}) {
        if (!modalEl && !initDOMElements()) {
            console.error('Global Media Picker Modal not found in DOM.');
            return;
        }

        currentCallback = options.onSelect || null;
        currentClearCallback = options.onClear || null;

        const currentVal = options.currentValue || '';
        activeSelection = null;

        fetchMediaLibrary();

        if (currentVal && allMediaImages.length) {
            const found = allMediaImages.find(x => x.path === currentVal || x.url === currentVal || currentVal.endsWith(x.name));
            if (found) {
                activeSelection = found;
            }
        }

        updateInspector();

        if (mediaModalInstance) {
            mediaModalInstance.show();
        }
    };

    /**
     * Auto-Attach Universal Media Picker to all Image Inputs across all Admin Pages
     */
    function autoEnhanceAdminImageInputs() {
        // Target inputs with image names or data attributes
        const selectors = [
            'input[name="image"]',
            'input[name="banner_img"]',
            'input[name="dean_photo"]',
            'input[name="photo"]',
            'input[name="photo_path"]',
            'input[name="logo"]',
            'input[name="fallback_img"]',
            'input[name="bg_image"]',
            'input[data-media-picker]',
            'input.media-picker-input'
        ];

        const inputs = document.querySelectorAll(selectors.join(', '));
        inputs.forEach(input => {
            if (input.dataset.mediaPickerAttached === 'true') return;
            input.dataset.mediaPickerAttached = 'true';

            // Wrap input in a modern image picker container
            const currentVal = input.value.trim();
            const wrapper = document.createElement('div');
            wrapper.className = 'admin-image-picker-field mb-2';

            const previewSrc = currentVal ? (currentVal.startsWith('http') ? currentVal : (window.BASE_URL || '') + currentVal) : '';

            wrapper.innerHTML = `
                <div class="d-flex align-items-center gap-2 p-2 bg-light rounded-3 border">
                    <div class="flex-shrink-0 bg-white border rounded-2 overflow-hidden d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; cursor: pointer;" title="Click to change image">
                        <img src="${previewSrc}" alt="Preview" class="w-100 h-100 object-fit-cover ${!previewSrc ? 'd-none' : ''}">
                        <i class="fas fa-image text-muted fs-4 ${previewSrc ? 'd-none' : ''}"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="text-truncate small font-monospace text-navy mb-1 fw-semibold text-path">${currentVal || '<span class="text-muted fst-italic">No image selected</span>'}</div>
                        <div class="d-flex gap-1">
                            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 btn-browse-gallery" style="font-size: 0.75rem;">
                                <i class="fas fa-images me-1"></i> Choose from Site Gallery
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 py-1 btn-clear-image ${!currentVal ? 'd-none' : ''}" style="font-size: 0.75rem;" title="Remove image">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Insert wrapper before input, and hide raw input or keep it for form submission
            input.parentNode.insertBefore(wrapper, input);
            input.type = 'hidden'; // Keep value updated for form submission

            const imgEl = wrapper.querySelector('img');
            const iconEl = wrapper.querySelector('i.fa-image');
            const pathLabel = wrapper.querySelector('.text-path');
            const browseBtn = wrapper.querySelector('.btn-browse-gallery');
            const clearImgBtn = wrapper.querySelector('.btn-clear-image');
            const thumbBox = wrapper.querySelector('.flex-shrink-0');

            function openThisPicker() {
                window.openMediaPicker({
                    currentValue: input.value,
                    onSelect: function(img) {
                        input.value = img.path;
                        imgEl.src = img.url;
                        imgEl.classList.remove('d-none');
                        iconEl.classList.add('d-none');
                        pathLabel.innerText = img.path;
                        clearImgBtn.classList.remove('d-none');

                        // Trigger change event on input for reactive forms
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    },
                    onClear: function() {
                        input.value = '';
                        imgEl.src = '';
                        imgEl.classList.add('d-none');
                        iconEl.classList.remove('d-none');
                        pathLabel.innerHTML = '<span class="text-muted fst-italic">No image selected</span>';
                        clearImgBtn.classList.add('d-none');
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });
            }

            browseBtn.addEventListener('click', openThisPicker);
            thumbBox.addEventListener('click', openThisPicker);

            clearImgBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                input.value = '';
                imgEl.src = '';
                imgEl.classList.add('d-none');
                iconEl.classList.remove('d-none');
                pathLabel.innerHTML = '<span class="text-muted fst-italic">No image selected</span>';
                clearImgBtn.classList.add('d-none');
                input.dispatchEvent(new Event('change', { bubbles: true }));
            });
        });
    }

    // Initialize on DOM Ready
    document.addEventListener('DOMContentLoaded', () => {
        initDOMElements();
        autoEnhanceAdminImageInputs();
    });

})();
