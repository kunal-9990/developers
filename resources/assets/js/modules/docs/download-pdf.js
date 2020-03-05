module.exports = () => {
    const BODY = document.querySelector('body');
    const DOWNLOAD_LINKS = document.querySelectorAll('.downloadLink');
    const MODAL_OVERLAY = document.querySelector('.pdf-modal');
    const MODAL_CLOSE = document.querySelector('.pdf-modal__close span');
    // const SUBSCRIBE = document.querySelector('.pdf-modal__subscribe-btn');
    // const DOWNLOAD_FILE = document.querySelector('.pdf-modal__file-download-btn');
    const EMAIL_INPUT_VALUE = document.querySelector('.email-sub-for-pdf');
    let fileName = null;

    $(document).ready(function () {
        $("#modal-download-btn").attr("href", "/download/" + $(".downloadLink").attr("filename"));
    });

    function togglePDFModalOverLay() {
        BODY.classList.contains('pdf-modal--shown')
            ? BODY.classList.remove('pdf-modal--shown')
            : BODY.classList.add('pdf-modal--shown');
    }

    // close modal
    function closeModal(e) {
        if (BODY.classList.contains('pdf-modal--shown')) {
            if (e.target === MODAL_OVERLAY || e.target === MODAL_CLOSE) {
                togglePDFModalOverLay();
            }
        }
    }

    DOWNLOAD_LINKS.forEach((link) => {
        // the two following lines are to remove
        // the bootstrap modal toggle data attrs
        // TODO: have writers remove these attrs from
        // TODO: template so we can remove these lines
        link.removeAttribute('data-toggle');
        link.removeAttribute('data-target');

        link.addEventListener('click', (event) => {
            fileName = link.getAttribute('filename');
            event.preventDefault();
            togglePDFModalOverLay();
        });
    });

    window.addEventListener('click', event => closeModal(event));
};
