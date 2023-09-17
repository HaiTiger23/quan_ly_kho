<div
    style="position: absolute; top:10px; right: 10px; z-index: 10000; display: flex; flex-direction: column; row-gap: 5px">
    @if (session()->has('success'))
        <div x-data={isVisible:true} x-init="setTimeout(function() { isVisible = false; }, 5000)">
            <div x-show="isVisible" class="alert alert-success">
                <div class="icon__wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: white;transform: ;msFilter:;">
                        <path d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path>
                    </svg>
                </div>
                <p>{{ session('success') }}.</p>
                <span class="mdi mdi-close close"></span>
            </div>
        </div>
    @endif
    @if (session()->has('warning'))
        <div x-data={isVisible:true} x-init="setTimeout(function() { isVisible = false; }, 5000)">
            <div x-show="isVisible" class="alert alert-warning">
                <div class="icon__wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: white;transform: ;msFilter:;">
                        <path
                            d="M11.953 2C6.465 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.493 2 11.953 2zM12 20c-4.411 0-8-3.589-8-8s3.567-8 7.953-8C16.391 4 20 7.589 20 12s-3.589 8-8 8z">
                        </path>
                        <path d="M11 7h2v7h-2zm0 8h2v2h-2z"></path>
                    </svg>
                </div>
                <p>{{ session('warning') }}.</p>
                <span class="mdi mdi-close close"></span>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data={isVisible:true} x-init="setTimeout(function() { isVisible = false; }, 5000)">
            <div x-show="isVisible" class="alert alert-error">
                <div class="icon__wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        style="fill: white;transform: ;msFilter:;">
                        <path
                            d="M11.953 2C6.465 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.493 2 11.953 2zM12 20c-4.411 0-8-3.589-8-8s3.567-8 7.953-8C16.391 4 20 7.589 20 12s-3.589 8-8 8z">
                        </path>
                        <path d="M11 7h2v7h-2zm0 8h2v2h-2z"></path>
                    </svg>
                </div>
                <p>{{ session('error') }}.</p>
                <span class="mdi mdi-close close"></span>
            </div>
        </div>
    @endif
</div>
