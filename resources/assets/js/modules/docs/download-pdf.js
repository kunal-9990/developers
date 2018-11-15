module.exports = () => {
    const BODY = document.querySelector('body');
    const DOWNLOAD_LINKS = document.querySelectorAll('.downloadLink');
    const MODAL_OVERLAY = document.querySelector('.pdf-modal');
    const MODAL_CLOSE = document.querySelector('.pdf-modal__close span');
    const SUBSCRIBE = document.querySelector('.pdf-modal__subscribe-btn');
    const DOWNLOAD_FILE = document.querySelector('.pdf-modal__file-download-btn');
    const EMAIL_INPUT_VALUE = document.querySelector('.email-sub-for-pdf');
    let fileName = null;

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

    function validateEmail(email) {
        const EMAIL_VALIDATION = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/; // eslint-disable-line no-useless-escape

        return EMAIL_VALIDATION.test(email);
    }

    function subscribe() {
        const USERS_EMAIL = EMAIL_INPUT_VALUE.value;

        if (validateEmail(USERS_EMAIL)) {
            $.post(
                '/assets/phpfunctions/email.php',
                {
                    page: window.location.href,
                    title: document.title,
                    email: USERS_EMAIL,
                    file: fileName,
                },
            );
        }
        togglePDFModalOverLay();
    }

    function downloadPDF() {
        $.post(
            '/assets/phpfunctions/email.php',
            {
                page: window.location.href,
                title: document.title,
                file: fileName,
            },
        );
        togglePDFModalOverLay();
        // window.open("/downloads/" + fileName, "_blank");
        window.location.assign("/downloads/" + fileName);


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

    SUBSCRIBE.addEventListener('click', () => subscribe());
    DOWNLOAD_FILE.addEventListener('click', () => downloadPDF());
    window.addEventListener('click', event => closeModal(event));
};
