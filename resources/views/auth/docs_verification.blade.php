@extends('layouts.app')

@section('title', 'Verify Documents')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <div class="bg-black/90 w-full max-w-2xl rounded-2xl shadow-xl p-6 sm:p-10">

            <!-- Logo & Progress Bar -->
            <div class="flex flex-col items-center w-full mb-8">
                <div class="mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Athenian Royalty Group Logo" class="h-20 w-auto">
                </div>

                <div class="w-full">
                    <div class="flex justify-between text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        <div class="flex items-center space-x-1 text-orange-600">
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                            <span>Registration</span>
                        </div>
                        <div class="flex items-center space-x-1 text-orange-600">
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                            <span>Email Verification</span>
                        </div>
                        <div class="flex items-center space-x-1 text-orange-600">
                            <div class="w-2 h-2 bg-orange-600 rounded-full"></div>
                            <span>Identity Verification</span>
                        </div>
                    </div>
                    <div class="w-full h-2 bg-gray-200 rounded-full">
                        <div class="h-full bg-orange-500 rounded-full" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            <h4 class="text-[20px] leading-[30px] font-bold mb-3 text-center text-white">Athenian Royalty Group - NYCCE</h4>
            <h4 class="text-[20px] leading-[30px] font-bold mb-3 text-center text-white">ID Verification and Payment</h4>
            <h1 class="text-start text-[28px] mb-3">Welcome!</h1>
            <p class="text-[14px] mb-2 text-white">
                To complete your transaction securely, we require a quick identity verification step before processing your payment. This helps us prevent fraud and keep your personal information protected.
            </p>
            <h1 class="text-start text-[20px] mb-3 text-white">Identity Verification Instructions</h1>
            <p class="text-[14px] mb-2 text-white">
                To ensure a smooth verification process, please follow these simple guidelines:
            </p>
            <ul class="text-[14px] mb-2 list-disc list-inside text-white">
                <li>Make sure your photo ID is clearly visible and not obstructed.</li>
                <li>Hold your ID steady and ensure all text is legible.</li>
                <li>Avoid using filters, flash reflections, or blurry images.</li>
                <li>If a selfie is required, ensure your face is fully visible, not cropped or shadowed</li>
            </ul>
            <p class="text-[14px] mb-2 list-disc list-inside text-white"> This process takes less than a minute and protects both you and our service from fraudulent activity.
            </p>
            @include('layouts.errors')


            <form method="POST" action="{{ route('verification.submit') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Document Type -->
                <div class="grid grid-cols4 sm:grid-cols2 gap-6">
                    <div class="space-y-4">
                        <label class="block text-md font-semibold opacity-80">Document Type</label>
                        <select name="documentType" required class="w-full rounded-md border border-gray-300 py-3 px-4">
                            <option value="">-- Select Type --</option>
                            <option value="1">ID</option>
                            <option value="2">Passport</option>
{{--                            <option value="3">Passport Card</option>--}}
{{--                            <option value="4">Common Access Card</option>--}}
{{--                            <option value="5">Uniformed Services ID</option>--}}
{{--                            <option value="6">GreenCard</option>--}}
{{--                            <option value="7">International ID</option>--}}
                        </select>
                    </div>
                    <input type="hidden" name="ssn" value="" />
                </div>

                <!-- Uploads -->
                <!-- Uploads with Drag & Drop and Preview -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ([
    'frontImage' => 'Front Image',
    'backImage' => 'Back/Second Image',
    'faceImage' => 'Face Image'
] as $field => $label)
                        <div class="space-y-2" id="{{ $field }}Container">
                            <label for="{{ $field }}" class="block text-sm font-semibold opacity-70">{{ $label }}</label>

                            <!-- Drag & Drop Zone -->
                            <div
                                class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 text-center transition hover:border-blue-400 hover:bg-gray-50 cursor-pointer"
                                ondrop="handleDrop(event, '{{ $field }}')"
                                ondragover="event.preventDefault();"
                                onclick="document.getElementById('{{ $field }}').click()"
                            >
                                <input
                                    type="file"
                                    name="{{ $field }}"
                                    id="{{ $field }}"
                                    accept="image/*"
                                    class="hidden"
                                    @if($field === 'frontImage') required @endif
                                    onchange="previewImage(this, '{{ $field }}Preview')"
                                />
                                <div id="{{ $field }}Preview" class="w-full h-32 flex items-center justify-center text-gray-400 text-sm">
                                    Drop or click to upload {{$label}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


                <!-- Hidden Options -->
{{--                <input type="checkbox" name="ocr" checked value="1" />--}}
{{--                <input type="checkbox" name="faceMatch" checked value="1" />--}}
{{--                <input type="checkbox" name="externalOFAC" value="1" />--}}

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-md">
                        Submit Verification
                    </button>
                </div>
            </form>

        </div>
    </div>

    <script>
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.innerHTML = `
                    <img src="${e.target.result}"
                         alt="Preview"
                         class="w-full h-32 object-cover rounded-md shadow-md border" />
                `;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleDrop(event, inputId) {
            event.preventDefault();
            const input = document.getElementById(inputId);
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                input.files = files;
                previewImage(input, inputId + 'Preview');
            }
        }


        document.addEventListener("DOMContentLoaded", function () {
            const docTypeSelect = document.querySelector("select[name='documentType']");
            const backImageContainer = document.getElementById("backImageContainer");

            function toggleBackImage() {
                if (docTypeSelect.value === "2") {
                    backImageContainer.style.display = "none";
                    document.getElementById('backImage').value = ""; // clear file input
                } else {
                    backImageContainer.style.display = "block";
                }
            }

            // Initial check on page load
            toggleBackImage();

            // Listen for change events
            docTypeSelect.addEventListener("change", toggleBackImage);
        });

    </script>

@endsection
