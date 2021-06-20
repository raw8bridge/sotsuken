const editorElement = document.getElementById('editor');
const resultElement = document.getElementById('result');
const undoElement = document.getElementById('undo');
const redoElement = document.getElementById('redo');
const clearElement = document.getElementById('clear');
const convertElement = document.getElementById('convert');

editorElement.addEventListener('changed', (event) => {
    undoElement.disabled = !event.detail.canUndo;
    redoElement.disabled = !event.detail.canRedo;
    clearElement.disabled = event.detail.isEmpty;
});

function cleanLatex(latexExport) {
    if (latexExport.includes('\\\\')) {
        const steps = '\\begin{align*}' + latexExport + '\\end{align*}';
        return steps.replace("\\begin{aligned}", "")
            .replace("\\end{aligned}", "")
            .replace(new RegExp("(align.{1})", "g"), "aligned");
    }
    return latexExport
        .replace(new RegExp("(align.{1})", "g"), "aligned");
}

editorElement.addEventListener('exported', (evt) => {

    const exports = evt.detail.exports;
    if (exports && exports['application/x-latex']) {
        convertElement.disabled = false;
        katex.render(cleanLatex(exports['application/x-latex']), resultElement);
        // resultElement.innerHTML = '<span>' + exports['application/x-latex'] + '</span>';
    } else if (exports && exports['application/mathml+xml']) {
        convertElement.disabled = false;
        resultElement.innerText = exports['application/mathml+xml'];
    } else if (exports && exports['application/mathofficeXML']) {
        convertElement.disabled = false;
        resultElement.innerText = exports['application/mathofficeXML'];
    } else {
        convertElement.disabled = true;
        resultElement.innerHTML = '';
    }
});
undoElement.addEventListener('click', () => {
    editorElement.editor.undo();
});
redoElement.addEventListener('click', () => {
    editorElement.editor.redo();
});
clearElement.addEventListener('click', () => {
    editorElement.editor.clear();
});
convertElement.addEventListener('click', () => {
    editorElement.editor.convert();
});

/**
 * Attach an editor to the document
 * @param {Element} The DOM element to attach the ink paper
 * @param {Object} The recognition parameters
 */
iink.register(editorElement, {
    recognitionParams: {
        type: 'MATH',
        protocol: 'WEBSOCKET',
        server: {
            scheme: 'https',
            host: 'webdemoapi.myscript.com',
            applicationKey: '',
            hmacKey: ''
        },
        iink: {
            math: {
                mimeTypes: ['application/x-latex', 'application/vnd.myscript.jiix']
            },
            export: {
                jiix: {
                    strokes: true
                }
            }
        }
    }
});

window.addEventListener('resize', () => {
    editorElement.editor.resize();
});