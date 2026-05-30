<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- PDF Toolbar -->
    <div class="bg-gray-100 border-b border-gray-200 px-3 sm:px-6 py-3 sm:py-4 flex flex-wrap items-center gap-2 sm:gap-4">
        <!-- Navigation Controls -->
        <div class="flex items-center gap-1 sm:gap-2">
            <button id="pdf-prev" class="p-2 hover:bg-gray-200 rounded transition-colors" title="Halaman Sebelumnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <input type="number" id="pdf-page-num" min="1" value="1" class="w-12 sm:w-16 px-2 py-1 border rounded text-center text-sm">
            <span id="pdf-total-pages" class="text-sm text-gray-600">/</span>
            <button id="pdf-next" class="p-2 hover:bg-gray-200 rounded transition-colors" title="Halaman Berikutnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-300 hidden sm:block"></div>

        <!-- Zoom Controls -->
        <div class="flex items-center gap-1 sm:gap-2">
            <button id="pdf-zoom-out" class="p-2 hover:bg-gray-200 rounded transition-colors" title="Perkecil">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/>
                </svg>
            </button>
            <span id="pdf-zoom-level" class="text-sm text-gray-600 min-w-fit">100%</span>
            <button id="pdf-zoom-in" class="p-2 hover:bg-gray-200 rounded transition-colors" title="Perbesar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/>
                </svg>
            </button>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-300 hidden sm:block"></div>

        <!-- Highlight Color Picker -->
        <div class="flex items-center gap-1 sm:gap-2">
            <label class="text-sm text-gray-600 hidden sm:inline">Highlight:</label>
            <div class="flex gap-1">
                <button class="pdf-highlight-color w-6 h-6 rounded border-2 hover:scale-110 transition-transform" data-color="yellow" style="background-color: rgba(255, 255, 0, 0.4); border-color: #FFD700;" title="Kuning"></button>
                <button class="pdf-highlight-color w-6 h-6 rounded border-2 hover:scale-110 transition-transform" data-color="green" style="background-color: rgba(144, 238, 144, 0.4); border-color: #32CD32;" title="Hijau"></button>
                <button class="pdf-highlight-color w-6 h-6 rounded border-2 hover:scale-110 transition-transform" data-color="pink" style="background-color: rgba(255, 192, 203, 0.4); border-color: #FF69B4;" title="Pink"></button>
                <button class="pdf-highlight-color w-6 h-6 rounded border-2 hover:scale-110 transition-transform" data-color="blue" style="background-color: rgba(173, 216, 230, 0.4); border-color: #4169E1;" title="Biru"></button>
                <button id="pdf-clear-highlights" class="px-2 py-1 text-sm bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors" title="Hapus Semua Highlight">
                    <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-300 hidden sm:block"></div>

        <!-- Download Button -->
        <a href="{{ route('surat-keluars.download', $suratKeluar) }}" class="ml-auto p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors text-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <span class="hidden sm:inline">Download</span>
        </a>
    </div>

    <!-- PDF Canvas -->
    <div id="pdf-container" class="overflow-auto bg-gray-200" style="height: 600px; display: flex; justify-content: center; align-items: flex-start; padding: 20px;">
        <canvas id="pdf-canvas"></canvas>
    </div>
</div>

<!-- PDF.js Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js"></script>

<script>
// Set worker
pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

let pdfDoc = null;
let currentPage = 1;
let zoom = 1;
let currentHighlightColor = 'yellow';
let highlights = new Map(); // Store highlights per page
let pageRendering = false;
let pageNumPending = null;

const pdfPath = '{{ asset($suratKeluar->file_surat ? 'storage/' . $suratKeluar->file_surat : '') }}';
const canvas = document.getElementById('pdf-canvas');
const ctx = canvas.getContext('2d');

// Highlight color mapping
const highlightColors = {
    yellow: { rgb: [255, 255, 0], opacity: 0.3 },
    green: { rgb: [144, 238, 144], opacity: 0.3 },
    pink: { rgb: [255, 192, 203], opacity: 0.3 },
    blue: { rgb: [173, 216, 230], opacity: 0.3 }
};

// Load PDF
async function loadPDF() {
    try {
        pdfDoc = await pdfjsLib.getDocument(pdfPath).promise;
        document.getElementById('pdf-total-pages').textContent = ' ' + pdfDoc.numPages;
        
        // Set default zoom level
        document.querySelector('.pdf-highlight-color[data-color="yellow"]').style.outline = '3px solid #333';
        
        renderPage(currentPage);
    } catch (error) {
        console.error('Error loading PDF:', error);
        alert('Gagal memuat PDF. Silakan coba lagi.');
    }
}

// Render page
async function renderPage(num) {
    if (pageRendering) {
        pageNumPending = num;
        return;
    }
    pageRendering = true;
    
    const page = await pdfDoc.getPage(num);
    const baseScale = 1.5;
    const scale = baseScale * zoom;
    const viewport = page.getViewport({ scale });

    // Set canvas dimensions
    canvas.width = viewport.width;
    canvas.height = viewport.height;

    const renderContext = {
        canvasContext: ctx,
        viewport: viewport
    };

    try {
        await page.render(renderContext).promise;
    } catch (error) {
        console.error('Error rendering page:', error);
    }

    pageRendering = false;
    document.getElementById('pdf-page-num').value = num;

    // Draw highlights
    drawHighlights(num);

    if (pageNumPending !== null) {
        renderPage(pageNumPending);
        pageNumPending = null;
    }
}

// Draw highlights on canvas
function drawHighlights(pageNum) {
    if (!highlights.has(pageNum) || highlights.get(pageNum).length === 0) return;

    const pageHighlights = highlights.get(pageNum);

    pageHighlights.forEach(highlight => {
        const color = highlightColors[highlight.color];
        ctx.fillStyle = `rgba(${color.rgb[0]}, ${color.rgb[1]}, ${color.rgb[2]}, ${color.opacity})`;
        ctx.fillRect(highlight.x, highlight.y, highlight.width, highlight.height);
    });
}

// Get selection rects
function getSelectionRects() {
    const selection = window.getSelection();
    if (selection.rangeCount === 0) return [];

    const rects = [];
    for (let i = 0; i < selection.rangeCount; i++) {
        const range = selection.getRangeAt(i);
        const clientRects = range.getClientRects();
        for (let j = 0; j < clientRects.length; j++) {
            rects.push(clientRects[j]);
        }
    }
    return rects;
}

// Add text selection listener
document.getElementById('pdf-container').addEventListener('mouseup', () => {
    setTimeout(() => {
        const selection = window.getSelection();
        if (selection.toString().length === 0) return;

        const rects = getSelectionRects();
        const canvasRect = canvas.getBoundingClientRect();
        const container = document.getElementById('pdf-container');

        rects.forEach(rect => {
            // Only highlight if selection is within canvas
            if (rect.left >= canvasRect.left && rect.right <= canvasRect.right &&
                rect.top >= canvasRect.top && rect.bottom <= canvasRect.bottom) {

                const highlight = {
                    x: rect.left - canvasRect.left,
                    y: rect.top - canvasRect.top,
                    width: rect.width,
                    height: rect.height,
                    color: currentHighlightColor
                };

                if (!highlights.has(currentPage)) {
                    highlights.set(currentPage, []);
                }
                highlights.get(currentPage).push(highlight);
            }
        });

        if (rects.length > 0) {
            renderPage(currentPage);
            selection.removeAllRanges();
        }
    }, 10);
});

// Navigation
document.getElementById('pdf-prev').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        renderPage(currentPage);
    }
});

document.getElementById('pdf-next').addEventListener('click', () => {
    if (pdfDoc && currentPage < pdfDoc.numPages) {
        currentPage++;
        renderPage(currentPage);
    }
});

document.getElementById('pdf-page-num').addEventListener('change', (e) => {
    const pageNum = parseInt(e.target.value) || 1;
    if (pageNum >= 1 && pdfDoc && pageNum <= pdfDoc.numPages) {
        currentPage = pageNum;
        renderPage(currentPage);
    }
});

// Zoom
document.getElementById('pdf-zoom-in').addEventListener('click', () => {
    zoom = Math.min(zoom + 0.2, 3);
    document.getElementById('pdf-zoom-level').textContent = Math.round(zoom * 100) + '%';
    renderPage(currentPage);
});

document.getElementById('pdf-zoom-out').addEventListener('click', () => {
    zoom = Math.max(zoom - 0.2, 0.5);
    document.getElementById('pdf-zoom-level').textContent = Math.round(zoom * 100) + '%';
    renderPage(currentPage);
});

// Keyboard navigation
document.addEventListener('keydown', (e) => {
    if (e.target.id === 'pdf-page-num') return;
    
    if (e.key === 'ArrowLeft' && currentPage > 1) {
        currentPage--;
        renderPage(currentPage);
    } else if (e.key === 'ArrowRight' && pdfDoc && currentPage < pdfDoc.numPages) {
        currentPage++;
        renderPage(currentPage);
    }
});

// Highlight color selection
document.querySelectorAll('.pdf-highlight-color').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.pdf-highlight-color').forEach(b => {
            b.style.outline = 'none';
        });
        currentHighlightColor = btn.dataset.color;
        btn.style.outline = '3px solid #333';
    });
});

// Clear highlights
document.getElementById('pdf-clear-highlights').addEventListener('click', () => {
    if (confirm('Yakin ingin menghapus semua highlight?')) {
        highlights.clear();
        renderPage(currentPage);
    }
});

// Load PDF on page load
if (pdfPath) {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadPDF);
    } else {
        loadPDF();
    }
}
</script>

<style>
.text-layer {
    user-select: text;
    -webkit-user-select: text;
}

.text-layer span {
    line-height: 1;
}

#pdf-canvas {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    max-width: 100%;
    border: 1px solid #ddd;
}

#pdf-container::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

#pdf-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#pdf-container::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

#pdf-container::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
