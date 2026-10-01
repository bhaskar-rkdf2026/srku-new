<!-- ══════════════════════════════════════════════════════════
     GLOBAL MEDIA LIBRARY & ASSET PICKER MODAL (Admin Panel)
     ══════════════════════════════════════════════════════════ -->
<div class="modal fade" id="globalMediaPickerModal" tabindex="-1" aria-labelledby="globalMediaPickerModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" style="max-width: 94vw;">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            
            <!-- MODAL HEADER -->
            <div class="modal-header bg-navy text-white px-4 py-3 align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-danger text-white rounded-3 p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="fas fa-photo-video fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-white mb-0" id="globalMediaPickerModalLabel">
                            Global Site Media Gallery
                        </h5>
                        <small class="text-white-50" style="font-size: 0.78rem;">
                            Browse existing images across the entire website or upload new ones instantly
                        </small>
                    </div>
                </div>

                <!-- Header Nav Tabs -->
                <div class="d-flex align-items-center gap-2 ms-auto me-3">
                    <ul class="nav nav-pills bg-white bg-opacity-10 p-1 rounded-pill" id="mediaPickerTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active px-3 py-1 text-white rounded-pill fw-semibold small" id="tab-gallery-btn" data-bs-toggle="pill" data-bs-target="#tab-gallery-pane" type="button" role="tab">
                                <i class="fas fa-th-large me-1"></i> Site Media Gallery (<span id="mediaTotalCount">0</span>)
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link px-3 py-1 text-white rounded-pill fw-semibold small" id="tab-upload-btn" data-bs-toggle="pill" data-bs-target="#tab-upload-pane" type="button" role="tab">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Upload New Image
                            </button>
                        </li>
                    </ul>
                </div>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- MODAL BODY -->
            <div class="modal-body p-0 bg-light" style="min-height: 520px; max-height: calc(85vh - 120px);">
                <div class="tab-content h-100" id="mediaPickerTabContent">
                    
                    <!-- TAB 1: MEDIA GALLERY BROWSER -->
                    <div class="tab-pane fade show active h-100" id="tab-gallery-pane" role="tabpanel">
                        <div class="d-flex flex-column h-100">
                            
                            <!-- Filter & Search Toolbar -->
                            <div class="p-3 bg-white border-bottom shadow-2xs">
                                <div class="row g-2 align-items-center">
                                    
                                    <!-- Search Input -->
                                    <div class="col-12 col-md-5">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" id="mediaSearchInput" class="form-control border-start-0 ps-0" placeholder="Search by image name or folder...">
                                            <button class="btn btn-outline-secondary" type="button" id="mediaSearchClear" title="Clear Search" style="display: none;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Folder Category Filter -->
                                    <div class="col-6 col-md-4">
                                        <select id="mediaFolderFilter" class="form-select form-select-sm">
                                            <option value="">📁 All Website Folders (All Images)</option>
                                        </select>
                                    </div>

                                    <!-- Sort Dropdown & Refresh -->
                                    <div class="col-6 col-md-3 d-flex gap-2">
                                        <select id="mediaSortSelect" class="form-select form-select-sm">
                                            <option value="newest">🕒 Newest First</option>
                                            <option value="oldest">🕒 Oldest First</option>
                                            <option value="name_asc">🔤 Name (A - Z)</option>
                                            <option value="size_desc">📦 Size (Largest)</option>
                                        </select>
                                        <button class="btn btn-sm btn-outline-primary flex-shrink-0" id="mediaRefreshBtn" title="Refresh Gallery">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Gallery + Inspector Area (Split Pane) -->
                            <div class="row g-0 flex-grow-1 overflow-hidden" style="min-height: 440px;">
                                
                                <!-- LEFT: Image Grid Display -->
                                <div class="col-12 col-lg-8 col-xl-9 p-3 overflow-auto bg-light border-end position-relative" id="mediaGridContainer" style="max-height: calc(85vh - 200px);">
                                    
                                    <!-- Loading State -->
                                    <div id="mediaGridLoader" class="text-center py-5">
                                        <div class="spinner-border text-danger" role="status">
                                            <span class="visually-hidden">Loading images...</span>
                                        </div>
                                        <p class="text-muted mt-2 small">Scanning website media files...</p>
                                    </div>

                                    <!-- Empty State -->
                                    <div id="mediaGridEmpty" class="text-center py-5 d-none">
                                        <i class="fas fa-images fa-3x text-muted opacity-50 mb-3 d-block"></i>
                                        <h6 class="text-navy fw-bold">No images found</h6>
                                        <p class="text-muted small">Try a different search term or folder filter, or upload a new image.</p>
                                    </div>

                                    <!-- Grid -->
                                    <div class="row g-2 g-md-3" id="mediaGrid">
                                        <!-- Dynamically Populated via JS -->
                                    </div>
                                </div>

                                <!-- RIGHT: Selected Image Inspector / Details Sidebar -->
                                <div class="col-12 col-lg-4 col-xl-3 p-3 bg-white overflow-auto" id="mediaInspectorContainer" style="max-height: calc(85vh - 200px);">
                                    
                                    <!-- No Selection Placeholder -->
                                    <div id="mediaInspectorEmpty" class="text-center py-5 text-muted">
                                        <div class="rounded-circle bg-light d-inline-flex p-3 mb-2">
                                            <i class="fas fa-mouse-pointer fa-2x text-secondary opacity-50"></i>
                                        </div>
                                        <h6 class="fw-bold text-navy small">No image selected</h6>
                                        <p class="small text-muted mb-0">Click any image thumbnail on the left to view details and use it on your page.</p>
                                    </div>

                                    <!-- Active Selection Details -->
                                    <div id="mediaInspectorContent" class="d-none">
                                        <div class="text-center bg-light p-2 rounded-3 border mb-3 overflow-hidden d-flex align-items-center justify-content-center" style="height: 180px;">
                                            <img id="inspectorImgPreview" src="" alt="" class="img-fluid rounded object-fit-contain" style="max-height: 100%; max-width: 100%;">
                                        </div>

                                        <div class="mb-3">
                                            <h6 class="fw-bold text-navy mb-1 text-break small" id="inspectorImgName">image.jpg</h6>
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill small" id="inspectorImgFolder">Uploads</span>
                                        </div>

                                        <div class="bg-light p-2 rounded-3 border mb-3 small">
                                            <div class="d-flex justify-content-between py-1 border-bottom">
                                                <span class="text-muted">Dimensions:</span>
                                                <strong class="text-navy" id="inspectorImgDims">1920 × 1080</strong>
                                            </div>
                                            <div class="d-flex justify-content-between py-1 border-bottom">
                                                <span class="text-muted">File Size:</span>
                                                <strong class="text-navy" id="inspectorImgSize">140 KB</strong>
                                            </div>
                                            <div class="d-flex justify-content-between py-1">
                                                <span class="text-muted">Modified:</span>
                                                <strong class="text-navy" id="inspectorImgDate">Sep 30, 2026</strong>
                                            </div>
                                        </div>

                                        <!-- Relative Path Box -->
                                        <div class="mb-2">
                                            <label class="form-label text-muted fw-bold mb-1" style="font-size: 0.72rem;">RELATIVE PATH:</label>
                                            <div class="input-group input-group-sm">
                                                <input type="text" id="inspectorImgPath" class="form-control bg-light font-monospace small" readonly>
                                                <button class="btn btn-outline-secondary" type="button" id="copyPathBtn" title="Copy Path">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Action Buttons in Sidebar -->
                                        <div class="d-flex gap-2 mt-3 pt-2 border-top">
                                            <a href="#" target="_blank" id="inspectorPreviewLink" class="btn btn-sm btn-outline-info flex-grow-1">
                                                <i class="fas fa-external-link-alt me-1"></i> Open Full
                                            </a>
                                            <button type="button" id="inspectorDeleteBtn" class="btn btn-sm btn-outline-danger" title="Delete from Server">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB 2: DRAG & DROP UPLOADER -->
                    <div class="tab-pane fade h-100 p-4 p-md-5" id="tab-upload-pane" role="tabpanel">
                        <div class="card border-2 border-dashed rounded-4 p-5 text-center bg-white shadow-sm h-100 d-flex flex-column align-items-center justify-content-center" id="mediaDropZone" style="cursor: pointer; border-color: #cbd5e1 !important; transition: all 0.25s ease;">
                            
                            <input type="file" id="mediaFileInput" class="d-none" multiple accept="image/*,.svg,.webp">
                            
                            <div class="rounded-circle bg-danger bg-opacity-10 text-danger p-4 mb-3 d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <i class="fas fa-cloud-upload-alt fa-3x"></i>
                            </div>

                            <h4 class="fw-bold text-navy mb-2">Drag &amp; Drop images here to upload</h4>
                            <p class="text-muted mb-3 small" style="max-width: 480px;">
                                Upload campus photos, banners, constituent logos, or leadership portraits. Supported formats: <strong>WebP, JPG, PNG, SVG, GIF</strong>.
                            </p>

                            <button type="button" class="btn btn-danger px-4 py-2 rounded-pill fw-bold shadow-sm" onclick="document.getElementById('mediaFileInput').click()">
                                <i class="fas fa-folder-open me-2"></i> Browse Computer Files
                            </button>

                            <!-- Upload Progress Container -->
                            <div id="mediaUploadProgressBox" class="w-100 mt-4 d-none" style="max-width: 400px;">
                                <div class="progress mb-2" style="height: 10px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 0%" id="mediaUploadProgressBar"></div>
                                </div>
                                <small class="text-muted" id="mediaUploadProgressText">Uploading image...</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- MODAL FOOTER -->
            <div class="modal-footer bg-white px-4 py-3 d-flex justify-content-between align-items-center border-top">
                <div class="d-flex align-items-center gap-2 text-truncate" style="max-width: 50%;">
                    <span class="text-muted small fw-semibold">Current:</span>
                    <span class="badge bg-light text-navy border text-truncate small font-monospace" id="mediaFooterCurrentSelection">None selected</span>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-danger btn-sm px-3 rounded-pill" id="mediaPickerClearBtn" title="Remove image and leave blank">
                        <i class="fas fa-times-circle me-1"></i> Remove / Clear Image
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm px-3 rounded-pill" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill fw-bold shadow-sm" id="mediaPickerInsertBtn" disabled>
                        <i class="fas fa-check me-1"></i> Use Selected Image
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
/* Global Media Picker Styles */
.media-card-item {
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    border: 2px solid transparent !important;
    background: #ffffff;
    user-select: none;
}
.media-card-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1 !important;
}
.media-card-item.selected {
    border-color: #dc2626 !important;
    background: #fef2f2 !important;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2) !important;
}
.media-card-item .selection-badge {
    position: absolute;
    top: 6px;
    right: 6px;
    background: #dc2626;
    color: #ffffff;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    z-index: 2;
}
.media-card-item.selected .selection-badge {
    display: flex;
}
#mediaDropZone.dragover {
    border-color: #dc2626 !important;
    background-color: #fef2f2 !important;
}
.media-picker-trigger-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
</style>
