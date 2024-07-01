@extends('app', [
    'title' => 'Enkripsi',
])

@section('content')
    @include('sweetalert::alert')
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6"></div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card shadow-sm mb-5">
                    <div class="card-header">
                        <h3 class="card-title">Menu Enkripsi</h3>
                    </div>
                    <form action="{{ route('encrypt') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-floating mb-7">
                                <input type="text" class="form-control form-control-solid" id="message" name="message"
                                    placeholder="Masukkan Pesan" required />

                                <label for="message" class="required">
                                    Pesannya apa?
                                </label>
                            </div>

                            <div class="form-floating">
                                <input type="text" class="form-control form-control-solid" id="key" name="key"
                                    placeholder="Masukkan Key" required />

                                <label for="key" class="required">
                                    Key
                                </label>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <button class="btn btn-sm btn-secondary hover-rotate-end" onclick="refreshPage()">
                                Refresh
                            </button>

                            <button type="submit" class="btn btn-sm btn-primary hover-rotate-start proses">
                                Proses
                            </button>
                        </div>
                    </form>
                </div>

                @if (isset($encryptedMessage))
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!--begin::Input wrapper-->
                            <div class="w-100">
                                <!--begin::Title-->
                                <h4 class="fs-5 fw-semibold text-gray-800">
                                    Hasil Enkripsi
                                </h4>
                                <!--end::Title-->

                                <!--begin::Title-->
                                <div class="d-flex">
                                    <input id="inputan" type="text"
                                        class="form-control form-control-solid me-3 flex-grow-1" name="search"
                                        value="{{ $encryptedMessage }}" />

                                    <button id="copy_button" class="btn btn-light fw-bold flex-shrink-0"
                                        data-clipboard-target="#inputan">
                                        Salin
                                    </button>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Input wrapper-->
                        </div>
                    </div>
                @endif
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@push('custom-javascript')
    <script src="https://unpkg.com/clipboard@2/dist/clipboard.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var button = document.querySelector('#copy_button');
            var input = document.querySelector('#inputan');
            var clipboard = new ClipboardJS(button);

            if (!clipboard) {
                console.log('ClipboardJS initialization failed');
                return;
            }

            clipboard.on('success', function(e) {
                var buttonCaption = button.innerHTML;
                input.classList.add('bg-success');
                input.classList.add('text-inverse-success');
                button.innerHTML = 'Tersalin';

                setTimeout(function() {
                    button.innerHTML = buttonCaption;
                    input.classList.remove('bg-success');
                    input.classList.remove('text-inverse-success');
                }, 3000);

                e.clearSelection();
            });

            clipboard.on('error', function(e) {
                console.log('ClipboardJS copy failed', e);
            });
        });

        function refreshPage() {
            location.reload();
        }
    </script>
@endpush
