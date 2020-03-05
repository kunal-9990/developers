
<div class="pdf-modal">
    <div class="pdf-modal__wrap">
        <div class="pdf-modal__body">
            @if (Auth::user())
                <h2 class="">Thank you</h2>
                <p class="">For subscribing to receive updates on the latest articles and news for CaseWare products.</p>
                <div class="pdf-modal__button-wrap">
                    {{-- <div class="pdf-modal__input-wrap">
                        <input type="text" class="email-sub-for-pdf" placeholder="Enter your email">
                    </div> --}}
                    <div id="error">Please register</div>
                    <button type="button" class="pdf-modal__subscribe-btn" style="display:none;">Subscribe</button>
                    {{-- <a href="login/github" class="btn btn-primary">
                        Login with Github
                    </a> --}}
                    <a id="modal-download-btn" href="" class="btn btn-primary btn-block"><b>Download</b></a>
                </div>            
            @else
                <h2 class="">Stay Connected</h2>
                <p class="">Subscribe to receive updates on the latest articles and news for CaseWare products.</p>
                <p class="">Your download will start immediately after you subscribe.</p>
                <div class="pdf-modal__button-wrap">
                    {{-- <div class="pdf-modal__input-wrap">
                        <input type="text" class="email-sub-for-pdf" placeholder="Enter your email">
                    </div> --}}
                    <div id="error">Please register</div>
                    <button type="button" class="pdf-modal__subscribe-btn" style="display:none;">Subscribe</button>
                    {{-- <a href="login/github" class="btn btn-primary">
                        Login with Github
                    </a> --}}
                    <div class="text-center social-btn">
                        <a href="/login/github"  class="btn btn-success btn-block"><i class="fab fa-github"></i>   Subscribe with <b>GitHub</b></a>
                        {{-- <a href="/login/facebook" class="btn btn-facebook btn-block"><i class="fab fa-facebook-f"></i> Subscribe with <b>Facebook</b></a> --}}
                        <a href="/login/twitter" class="btn btn-twitter btn-block"><i class="fab fa-twitter"></i> Subscribe with <b>Twitter</b></a>
                        <a href="/login/google" class="btn btn-google btn-block"><i class="fab fa-google"></i> Subscribe with <b>Google</b></a>
                        <a href="/login/linkedin" class="btn btn-linkedin btn-block"><i class="fab fa-linkedin-in"></i> Subscribe with <b>LinkedIn</b></a>
                    </div>
                </div>
            @endif

            {{-- <a class="pdf-modal__file-download-btn">No thanks, I just want the file.</a> --}}
        </div>
        <div class="pdf-modal__footer">
            <p>Don't have a cloud yet? <a href="https://casewarecloud.com/" target="_blank">Click to learn more</a></p>
        </div>
        <div class="pdf-modal__close">
            {{-- <span class="pdf-modal__close-text">close</span> --}}
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
        </div>
    </div>
</div>