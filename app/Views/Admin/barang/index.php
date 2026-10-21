<?= $this->extend('Admin/layout/admin') ?>
<?= $this->section('content') ?>

<style>
    /* ============================================
       PRODUK MANAGEMENT STYLES
    ============================================ */
    :root {
        --gold: #B8963E;
        --gold-light: #D4B766;
        --gold-pale: #F3ECD9;
        --green-deep: #164534;
        --green-mid: #1F5C46;
        --green-pale: #EAF3EE;
        --cream: #F7F5F0;
        --white: #FFFFFF;
        --gray-50: #F7F5F0;
        --gray-100: #F1EFE9;
        --gray-200: #E9E7E2;
        --gray-300: #DEE2E6;
        --gray-400: #CED4DA;
        --gray-500: #ADB5BD;
        --gray-600: #6D6D6D;
        --gray-700: #495057;
        --radius-card: 20px;
        --radius-pill: 100px;
        --transition: all 0.3s cubic-bezier(0.2, 0, 0, 1);
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, var(--green-deep) 0%, var(--green-mid) 100%);
        border-radius: 24px;
        padding: 28px 32px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '🌸';
        position: absolute;
        top: -30px;
        right: -20px;
        font-size: 120px;
        opacity: 0.06;
    }
    
    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.8rem;
        font-weight: 500;
        color: white;
        margin-bottom: 8px;
    }
    
    .page-subtitle {
        color: rgba(255,255,255,0.7);
        font-size: 0.9rem;
    }

    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 20px;
        padding: 20px 24px;
        margin-bottom: 32px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: center;
        justify-content: space-between;
    }
    
    .filter-group {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }
    
    .filter-input {
        border: 1px solid var(--gray-200);
        border-radius: 12px;
        padding: 10px 16px;
        font-size: 0.85rem;
        transition: var(--transition);
        background: var(--gray-50);
    }
    
    .filter-input:focus {
        outline: none;
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(184,150,62,0.1);
    }
    
    .btn-add {
        background: linear-gradient(135deg, var(--green-deep), var(--green-mid));
        border: none;
        border-radius: 12px;
        padding: 10px 24px;
        color: white;
        font-weight: 600;
        transition: var(--transition);
    }
    
    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22,69,52,0.2);
        background: linear-gradient(135deg, var(--green-mid), var(--green-deep));
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        height: 100%;
        position: relative;
    }
    
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        border-color: rgba(184,150,62,0.2);
    }
    
    .product-img-wrap {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: var(--green-pale);
    }
    
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .product-img {
        transform: scale(1.05);
    }
    
    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 600;
        color: white;
        z-index: 2;
    }
    
    .product-badge.available {
        background: var(--green-mid);
    }
    
    .product-badge.sold-out {
        background: #FF4757;
    }
    
    .product-badge.promo {
        background: #FF4757;
        top: auto;
        bottom: 12px;
        left: 12px;
    }
    
    .product-body {
        padding: 16px;
    }
    
    .product-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--green-deep);
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .product-price {
        margin-bottom: 8px;
    }
    
    .price-current {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gold);
    }
    
    .price-original {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-decoration: line-through;
        margin-left: 6px;
    }
    
    .product-stok {
        font-size: 0.75rem;
        color: var(--gray-600);
        margin-bottom: 12px;
    }
    
    .product-stok span {
        font-weight: 600;
        color: var(--green-mid);
    }
    
    .product-actions {
        display: flex;
        gap: 8px;
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid var(--gray-200);
    }
    
    
    
    /* Discount Badge */
.discount-badge {
    display: inline-block;
    background: #e74c3c;
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 20px;
    margin-left: 8px;
}



    
    .btn-edit, .btn-delete {
        flex: 1;
        padding: 8px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
    }
    
    .btn-edit {
        background: var(--green-pale);
        color: var(--green-deep);
    }
    
    .btn-edit:hover {
        background: var(--green-deep);
        color: white;
    }
    
    .btn-delete {
        background: rgba(255,71,87,0.1);
        color: #FF4757;
    }
    
    .btn-delete:hover {
        background: #FF4757;
        color: white;
    }

    /* Skeleton Loading */
    .skeleton-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }
    
    .skeleton-img {
        height: 200px;
        background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    .skeleton-text {
        height: 16px;
        background: linear-gradient(90deg, var(--gray-200) 25%, var(--gray-100) 50%, var(--gray-200) 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        border-radius: 8px;
        margin: 12px;
    }
    
    .skeleton-text-sm {
        height: 12px;
        width: 60%;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    /* Pagination */
    .pagination-modern {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 40px;
    }
    
    .pagination-modern .page-link {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 1px solid var(--gray-200);
        color: var(--gray-700);
        text-decoration: none;
        transition: var(--transition);
    }
    
    .pagination-modern .page-link:hover,
    .pagination-modern .active .page-link {
        background: var(--gold);
        border-color: var(--gold);
        color: white;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    
    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--green-pale);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    
    .empty-state-icon i {
        font-size: 2rem;
        color: var(--green-mid);
    }
    
    .empty-state-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--green-deep);
        margin-bottom: 8px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px 24px;
        }
        .page-title {
            font-size: 1.4rem;
        }
        .filter-bar {
            flex-direction: column;
            align-items: stretch;
        }
        .filter-group {
            flex-direction: column;
        }
        .filter-input {
            width: 100%;
        }
    }
</style>

<div class="produk-management">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="page-title">Koleksi Produk</h1>
                <p class="page-subtitle">Kelola semua produk YSP Jasmine dalam satu dashboard</p>
            </div>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#produkModal" onclick="resetForm()">
                <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
            </button>
        </div>
    </div>
    
    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group">
            <div class="position-relative">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--gray-500); font-size: 0.8rem;"></i>
                <input type="text" id="searchInput" class="filter-input" placeholder="Cari produk..." style="padding-left: 38px; width: 260px;">
            </div>
            <select id="kategoriFilter" class="filter-input" style="width: 160px;">
                <option value="">Semua Kategori</option>
                <option value="tersedia">Tersedia</option>
                <option value="habis">Stok Habis</option>
            </select>
            <select id="sortFilter" class="filter-input" style="width: 160px;">
                <option value="terbaru">Terbaru</option>
                <option value="harga_asc">Harga Terendah</option>
                <option value="harga_desc">Harga Tertinggi</option>
                <option value="stok_asc">Stok Terendah</option>
            </select>
        </div>
        <div>
            <span class="text-muted small" id="resultCount"></span>
        </div>
    </div>
    
    <!-- Product Grid -->
    <div class="row g-4" id="produkGrid">
        <!-- Skeleton Loading akan muncul di sini -->
    </div>
    
    <!-- Pagination -->
    <div id="paginationContainer" class="pagination-modern"></div>
    
</div>

<!-- ============================================
     MODAL TAMBAH / EDIT PRODUK
============================================ -->
<div class="modal fade" id="produkModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="overflow: hidden;">
            <div class="modal-header border-0" style="padding: 20px 28px;">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding: 28px;">
                <form id="produkForm" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" id="produkId" name="id" value="">
                    
                    <div class="row g-3">
                        <!-- Nama Produk -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required 
                                   style="border-radius: 12px; padding: 12px; border: 1px solid var(--gray-200);">
                            <div class="invalid-feedback">Nama produk wajib diisi</div>
                        </div>
                        
                        <!-- Stok -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="stok" name="stok" required 
                                style="border-radius: 12px; padding: 12px;" min="0">
                            <small class="text-muted">Stok 0 (produk habis)</small>
                        </div>
                        
                        <!-- Harga -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="harga" name="harga" required 
                                   style="border-radius: 12px; padding: 12px;" 
                                   onkeyup="formatRupiah(this)">
                        </div>
                        
                        <!-- Harga Diskon -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Harga Diskon (Opsional)</label>
                            <input type="text" class="form-control" id="harga_diskon" name="harga_diskon" 
                                   style="border-radius: 12px; padding: 12px;"
                                   onkeyup="formatRupiah(this)">
                            <small class="text-muted">Kosongkan jika tidak ada diskon</small>
                        </div>
                        
                        <!-- Promo -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status Promo</label>
                            <select class="form-select" id="is_promo" name="is_promo" style="border-radius: 12px; padding: 12px;">
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                        
                        <!-- Gambar -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gambar Produk</label>
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*"
                                   style="border-radius: 12px; padding: 10px;">
                            <small class="text-muted">Format: JPG, PNG. Max: 2MB</small>
                            <div id="gambarPreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px;">
                            </div>
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi Produk</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" 
                                      style="border-radius: 12px; padding: 12px;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0" style="padding: 20px 28px; background: var(--gray-50);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 12px; padding: 10px 24px;">Batal</button>
                <button type="button" class="btn btn-primary" id="saveProdukBtn" style="border-radius: 12px; padding: 10px 32px; background: var(--green-deep); border: none;">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ============================================
    // VARIABLES
    // ============================================
    let currentPage = 1;
    let searchQuery = '';
    let kategoriFilter = '';
    let sortBy = 'terbaru';
    let isLoading = false;
    
    // ============================================
    // FETCH PRODUCTS
    // ============================================
    async function fetchProducts() {
        if (isLoading) return;
        isLoading = true;
        
        showSkeleton();
        
        try {
            const response = await fetch(`<?= base_url('admin/barang/getProducts') ?>?page=${currentPage}&search=${searchQuery}&kategori=${kategoriFilter}&sort=${sortBy}`);
            const data = await response.json();
            
            if (data.success) {
                renderProducts(data.data);
                renderPagination(data.pagination);
                document.getElementById('resultCount').innerText = `${data.total} produk ditemukan`;
            } else {
                showEmptyState();
            }
        } catch (error) {
            console.error('Error:', error);
            showEmptyState();
        } finally {
            isLoading = false;
        }
    }
    
    // ============================================
    // SHOW SKELETON
    // ============================================
    function showSkeleton() {
        const grid = document.getElementById('produkGrid');
        grid.innerHTML = '';
        for (let i = 0; i < 8; i++) {
            grid.innerHTML += `
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="skeleton-card">
                        <div class="skeleton-img"></div>
                        <div class="skeleton-text" style="margin-top: 12px; width: 80%;"></div>
                        <div class="skeleton-text skeleton-text-sm"></div>
                        <div class="skeleton-text" style="width: 50%;"></div>
                    </div>
                </div>
            `;
        }
    }
    
    function showEmptyState() {
        const grid = document.getElementById('produkGrid');
        grid.innerHTML = `
            <div class="col-12">
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-box-open"></i></div>
                    <div class="empty-state-title">Belum Ada Produk</div>
                    <p class="text-muted">Klik tombol "Tambah Produk Baru" untuk mulai menambahkan produk</p>
                </div>
            </div>
        `;
        document.getElementById('paginationContainer').innerHTML = '';
        document.getElementById('resultCount').innerText = '0 produk ditemukan';
    }
    
// ============================================
// RENDER PRODUCTS - RONCE SELALU PRE-ORDER
// ============================================
function renderProducts(products) {
    const grid = document.getElementById('produkGrid');
    
    if (!products || products.length === 0) {
        showEmptyState();
        return;
    }
    
    grid.innerHTML = products.map(product => {
        // ============================================
        // LOGIKA PRE-ORDER UNTUK RONCE
        // ============================================
        const nama = product.nama_barang.toLowerCase();
        const isRonce = nama.includes('ronce') || nama.includes('pengantin') || nama.includes('gelang') || nama.includes('set');
        
        // ========== LOGIKA UTAMA ==========
        // 1. RONCE/PENGANTIN/GELANG/SET = SELALU PRE-ORDER (stok berapapun)
        // 2. MELATI FRESH = tersedia jika stok > 0, habis jika stok = 0
        // ==================================
        let badgeHtml = '';
        let statusText = '';
        let statusColor = '';
        
        if (isRonce) {
            // RONCE = SELALU PRE-ORDER
            badgeHtml = `<span class="product-badge" style="background: #FF6B35; color: white; position: absolute; top: 12px; left: 12px; padding: 5px 12px; border-radius: 30px; font-size: 0.7rem; font-weight: 600; z-index: 2;">
                <i class="fas fa-clock me-1"></i> Pre-Order (H-1)
            </span>`;
            statusText = ' (Pesan H-1)';
            statusColor = '#FF6B35';
        } else if (product.stok <= 0) {
            // MELATI FRESH STOK 0 = HABIS
            badgeHtml = `<span class="product-badge sold-out"><i class="fas fa-times-circle me-1"></i> Habis</span>`;
            statusText = ' (Habis)';
            statusColor = '#e74c3c';
        } else {
            // MELATI FRESH STOK > 0 = TERSEDIA
            badgeHtml = `<span class="product-badge available"><i class="fas fa-check-circle me-1"></i> Tersedia</span>`;
            statusText = '';
            statusColor = '#27ae60';
        }
        
        // Hitung persentase diskon
        let discountPercent = 0;
        if (product.is_promo && product.harga_diskon && product.harga > 0) {
            discountPercent = Math.round(((product.harga - product.harga_diskon) / product.harga) * 100);
        }
        
        return `
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="product-card">
                    <div class="product-img-wrap">
                        <img src="<?= base_url('uploads/') ?>${product.gambar || 'default.png'}" 
                             alt="${escapeHtml(product.nama_barang)}" 
                             class="product-img"
                             onerror="this.src='<?= base_url('uploads/default.png') ?>'">
                        ${badgeHtml}
                        ${product.is_promo && product.harga_diskon ? '<span class="product-badge promo"><i class="fas fa-tag me-1"></i> Promo</span>' : ''}
                    </div>
                    <div class="product-body">
                        <h5 class="product-name" title="${escapeHtml(product.nama_barang)}">${escapeHtml(product.nama_barang)}</h5>
                        <div class="product-price">
                            ${product.is_promo && product.harga_diskon ? `
                                <span class="price-current">Rp ${formatNumber(product.harga_diskon)}</span>
                                <span class="price-original">Rp ${formatNumber(product.harga)}</span>
                                <span class="discount-badge">-${discountPercent}%</span>
                            ` : `
                                <span class="price-current">Rp ${formatNumber(product.harga)}</span>
                            `}
                        </div>
                        <div class="product-stok">
                            <i class="fas fa-box me-1"></i> Stok: <span>${product.stok}</span> unit
                            ${statusText ? `<span style="color: ${statusColor}; font-weight: 600; margin-left: 8px;">${statusText}</span>` : ''}
                        </div>
                        <div class="product-actions">
                            <button class="btn-edit" onclick="editProduct(${product.id})">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button class="btn-delete" onclick="deleteProduct(${product.id}, '${escapeHtml(product.nama_barang)}')">
                                <i class="fas fa-trash-alt me-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

    // ============================================
    // RENDER PAGINATION
    // ============================================
    function renderPagination(pagination) {
        const container = document.getElementById('paginationContainer');
        if (!pagination || pagination.totalPages <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let html = '';
        if (pagination.currentPage > 1) {
            html += `<a href="#" class="page-link" onclick="changePage(${pagination.currentPage - 1}); return false;">«</a>`;
        }
        
        for (let i = 1; i <= pagination.totalPages; i++) {
            if (i === pagination.currentPage) {
                html += `<span class="active"><span class="page-link">${i}</span></span>`;
            } else if (Math.abs(i - pagination.currentPage) <= 2) {
                html += `<a href="#" class="page-link" onclick="changePage(${i}); return false;">${i}</a>`;
            }
        }
        
        if (pagination.currentPage < pagination.totalPages) {
            html += `<a href="#" class="page-link" onclick="changePage(${pagination.currentPage + 1}); return false;">»</a>`;
        }
        
        container.innerHTML = html;
    }
    
    // ============================================
    // CHANGE PAGE
    // ============================================
    function changePage(page) {
        currentPage = page;
        fetchProducts();
    }
    
    // ============================================
    // FILTER & SEARCH
    // ============================================
    document.getElementById('searchInput').addEventListener('input', debounce(function(e) {
        searchQuery = e.target.value;
        currentPage = 1;
        fetchProducts();
    }, 500));
    
    document.getElementById('kategoriFilter').addEventListener('change', function(e) {
        kategoriFilter = e.target.value;
        currentPage = 1;
        fetchProducts();
    });
    
    document.getElementById('sortFilter').addEventListener('change', function(e) {
        sortBy = e.target.value;
        currentPage = 1;
        fetchProducts();
    });
    
    // ============================================
// TOGGLE PROMO FIELDS (disable diskon jika promo nonaktif)
// ============================================
function togglePromoFields() {
    const isPromoSelect = document.getElementById('is_promo');
    const diskonField = document.getElementById('harga_diskon');
    
    if (isPromoSelect && diskonField) {
        if (isPromoSelect.value == '0') {
            // Jika promo tidak aktif, kosongkan dan disable field diskon
            diskonField.value = '';
            diskonField.disabled = true;
            diskonField.style.backgroundColor = '#E9E7E2';
            diskonField.style.cursor = 'not-allowed';
        } else {
            // Jika promo aktif, enable field diskon
            diskonField.disabled = false;
            diskonField.style.backgroundColor = '';
            diskonField.style.cursor = 'text';
            diskonField.required = false;
        }
    }
}
    
// ============================================
// SAVE PRODUCT (CREATE/UPDATE) - DIPERBAIKI
// ============================================
document.getElementById('saveProdukBtn').addEventListener('click', async function() {
    const form = document.getElementById('produkForm');
    const formData = new FormData(form);
    const produkId = document.getElementById('produkId').value;
    const isEdit = produkId !== '';
    const url = isEdit ? `<?= base_url('admin/barang/update/') ?>${produkId}` : `<?= base_url('admin/barang/create') ?>`;
    
    // Validasi dasar
    if (!formData.get('nama_barang')) {
        Swal.fire('Error', 'Nama produk wajib diisi', 'error');
        return;
    }
    if (!formData.get('harga')) {
        Swal.fire('Error', 'Harga produk wajib diisi', 'error');
        return;
    }
    
    // PERBAIKAN: Stok 0 diperbolehkan (tidak perlu validasi khusus)
    // Stok bisa 0, 1, 2, dst.
    
    // Ambil nilai
    const isPromo = document.getElementById('is_promo').value;
    let harga = document.getElementById('harga').value.replace(/[^0-9]/g, '');
    let hargaDiskon = document.getElementById('harga_diskon').value.replace(/[^0-9]/g, '');
    
    // ========== LOGIKA PROMO FLEKSIBEL ==========
    if (isPromo == '1') {
        // Jika promo AKTIF, harga diskon wajib diisi
        if (!hargaDiskon || hargaDiskon == '0') {
            Swal.fire('Error', 'Harga diskon wajib diisi jika promo aktif!', 'error');
            return;
        }
    } else {
        // Jika promo TIDAK AKTIF - kosongkan harga diskon
        hargaDiskon = '';
    }
    // ============================================
    
    formData.set('harga', harga);
    formData.set('harga_diskon', hargaDiskon);
    formData.set('is_promo', isPromo);
    
    const btn = this;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    btn.disabled = true;
    
    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            Swal.fire('Berhasil!', data.message, 'success');
            $('#produkModal').modal('hide');
            resetForm();
            fetchProducts();
        } else {
            let errorMsg = data.message;
            if (typeof errorMsg === 'object') {
                errorMsg = Object.values(errorMsg).join('<br>');
            }
            Swal.fire('Gagal!', errorMsg || 'Terjadi kesalahan', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire('Error!', 'Gagal menyimpan data', 'error');
    } finally {
        btn.innerHTML = '<i class="fas fa-save me-2"></i>Simpan';
        btn.disabled = false;
    }
});
    // ============================================
    // EDIT PRODUCT - DIPERBAIKI
    // ============================================
    async function editProduct(id) {
        try {
            const response = await fetch(`<?= base_url('admin/barang/getProduct/') ?>${id}`);
            const data = await response.json();
            
            if (data.success) {
                document.getElementById('modalTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Produk';
                document.getElementById('produkId').value = data.data.id;
                document.getElementById('nama_barang').value = data.data.nama_barang;
                document.getElementById('stok').value = data.data.stok;
                document.getElementById('deskripsi').value = data.data.deskripsi || '';
                
                // Set promo values
                const isPromo = data.data.is_promo || 0;
                document.getElementById('is_promo').value = isPromo;
                
                // Format harga ke rupiah
                document.getElementById('harga').value = formatRupiahValue(data.data.harga);
                
                // Handle harga diskon
                const diskonField = document.getElementById('harga_diskon');
                if (data.data.harga_diskon && data.data.harga_diskon > 0) {
                    diskonField.value = formatRupiahValue(data.data.harga_diskon);
                } else {
                    diskonField.value = '';
                }
                
                // Trigger toggle promo fields untuk mengatur enable/disable
                togglePromoFields();
                
                // Preview gambar
                if (data.data.gambar && data.data.gambar !== 'default.png') {
                    document.getElementById('gambarPreview').style.display = 'block';
                    document.getElementById('previewImg').src = `<?= base_url('uploads/') ?>${data.data.gambar}`;
                } else {
                    document.getElementById('gambarPreview').style.display = 'none';
                    document.getElementById('previewImg').src = '';
                }
                
                $('#produkModal').modal('show');
            } else {
                Swal.fire('Error', 'Gagal mengambil data produk', 'error');
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', 'Gagal mengambil data produk', 'error');
        }
    }
    
    // ============================================
    // DELETE PRODUCT
    // ============================================
    async function deleteProduct(id, name) {
        const result = await Swal.fire({
            title: 'Hapus Produk?',
            html: `Apakah Anda yakin ingin menghapus <strong>${name}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF4757',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        });
        
        if (result.isConfirmed) {
            try {
                const response = await fetch(`<?= base_url('admin/barang/delete/') ?>${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?= csrf_header() ?>': '<?= csrf_hash() ?>'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    Swal.fire('Terhapus!', data.message, 'success');
                    fetchProducts();
                } else {
                    Swal.fire('Gagal!', data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire('Error!', 'Gagal menghapus produk', 'error');
            }
        }
    }
    
    // ============================================
    // RESET FORM - DIPERBAIKI
    // ============================================
    function resetForm() {
        document.getElementById('modalTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru';
        document.getElementById('produkForm').reset();
        document.getElementById('produkId').value = '';
        document.getElementById('gambarPreview').style.display = 'none';
        document.getElementById('previewImg').src = '';
        
        // Reset promo fields
        const isPromoSelect = document.getElementById('is_promo');
        const diskonField = document.getElementById('harga_diskon');
        
        if (isPromoSelect) isPromoSelect.value = '0';
        if (diskonField) {
            diskonField.disabled = false;
            diskonField.style.backgroundColor = '';
            diskonField.value = '';
        }
    }
    
    // ============================================
    // PREVIEW GAMBAR
    // ============================================
    const gambarInput = document.getElementById('gambar');
    if (gambarInput) {
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('gambarPreview').style.display = 'block';
                    document.getElementById('previewImg').src = event.target.result;
                }
                reader.readAsDataURL(file);
            } else {
                document.getElementById('gambarPreview').style.display = 'none';
                document.getElementById('previewImg').src = '';
            }
        });
    }
    
    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    function formatRupiah(input) {
        let value = input.value.replace(/[^0-9]/g, '');
        if (value) {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        } else {
            input.value = '';
        }
    }
    
    function formatRupiahValue(value) {
        if (!value || value == 0) return '';
        return new Intl.NumberFormat('id-ID').format(value);
    }
    
    function formatNumber(value) {
        return new Intl.NumberFormat('id-ID').format(value);
    }
    
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if (m === '&') return '&amp;';
            if (m === '<') return '&lt;';
            if (m === '>') return '&gt;';
            return m;
        });
    }
    
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // ============================================
    // EVENT LISTENERS
    // ============================================
    // Event listener untuk perubahan status promo
    const isPromoSelect = document.getElementById('is_promo');
    if (isPromoSelect) {
        isPromoSelect.addEventListener('change', togglePromoFields);
    }
    
    // ============================================
    // INIT
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        fetchProducts();
        
        // Inisialisasi toggle promo fields
        togglePromoFields();
    });
</script>


<?= $this->endSection() ?>