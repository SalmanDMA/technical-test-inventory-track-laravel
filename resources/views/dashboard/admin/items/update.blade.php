<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Items" />

<x-dashboard.layout>
    <div class="mx-auto max-w-screen-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard.items') }}"
                class="text-slate-400 hover:text-slate-500 mb-4 inline-block font-gelasio">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>
            <h2 class="text-3xl font-bold text-slate-950 font-poppins">
                Form Layout Update Item
            </h2>
        </div>

        <div class="flex flex-col gap-9">
            <div class="rounded-sm border border-slate-300 bg-white shadow-lg">
                <form id="itemForm" class="py-4 px-6 flex flex-col gap-4">
                    <x-input-field name="name" labelName="Name" placeholder="Enter your name here..." type="text"
                        requiredInput="true" value="{{ $item->name }}" />

                    <x-input-field name="quantity" labelName="Quantity" placeholder="Enter your quantity here..."
                        type="number" requiredInput="true" value="{{ $item->quantity }}" />

                    <div class="flex flex-col gap-2">
                        <p class="mb-2 block text-sm font-medium text-slate-950 font-poppins">
                            Image<span class="text-red-500">*</span>
                        </p>
                        <div id="imageContainer"
                            class="flex items-center justify-center rounded-lg border-2 border-dashed border-primary bg-transparent p-8 transition duration-300 ease-in-out min-h-[300px]">
                            <label for="imageInput"
                                class="h-full w-full cursor-pointer min-h-[300px] flex justify-center items-center">
                                <input type="file" accept="image/jpeg,image/png,image/jpg"
                                    class="hidden h-full w-full" id="imageInput" name="image" />
                                <div class="hidden" id="previewImageContainer">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <img id="previewImage" />
                                        <div class="mt-4 flex gap-2" id="imageButtons">
                                            <button type="button" id="removeImage"
                                                class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-gray-600 disabled:pointer-events-none disabled:opacity-50 font-gelasio">
                                                Choose image again
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <p id="imagePlaceholder" class="text-center text-slate-400 font-gelasio">
                                    Upload a image or drag and drop <br /> PNG,JPG,JPEG up to 2MB
                                </p>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit"
                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 text-white font-gelasio">
                            Update Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const imageContainer = $('#imageContainer');
            const imageInput = $('#imageInput');
            const previewImageContainer = $('#previewImageContainer');
            const previewImage = $('#previewImage');
            const imagePlaceholder = $('#imagePlaceholder');
            const removeImage = $('#removeImage');
            const imageButtons = $('#imageButtons');
            let temporaryImageFile = null;
            const quantity = $('#quantity');

            @if ($item->image)
                imageContainer.removeClass('hidden');
                imagePlaceholder.addClass('hidden');
                previewImageContainer.removeClass('hidden');
                imageButtons.addClass('hidden');
                previewImage.attr('src', "{{ Storage::url('photo-items/' . $item->image) }}");
            @endif

            $('#itemForm').on('submit', function(e) {
                e.preventDefault();

                const name = $('#name').val();

                if (!name) {
                    toastr.error('Name is required');
                    $('#name').focus();
                    return;
                }

                if (name.length < 3) {
                    toastr.error('Name must be at least 3 characters long');
                    $('#name').focus();
                    return;
                }

                if (!quantity) {
                    toastr.error('Quantity is required');
                    $('#quantity').focus();
                    return;
                }

                if (temporaryImageFile === null) {
                    toastr.error('Image is required');
                    return;
                }

                imageContainer.removeClass('border-primary');

                const quantityValue = parseInt(quantity.val());

                const formData = new FormData();
                formData.append('item_id', "{{ $item->id }}");
                formData.append('name', name);
                formData.append('quantity', quantityValue);
                if (temporaryImageFile !== null) {
                    formData.append('image', temporaryImageFile);
                    formData.append('oldImage', "{{ $item->image }}");
                }


                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('dashboard.items.add.post.update') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('dashboard.items') }}";
                            }, 1000);
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            toastr.error(xhr.responseJSON.message[0]);
                        }
                        console.error(xhr.responseText);
                    }
                });

            });

            imageContainer.on('dragover', function(event) {
                event.preventDefault();
                imageContainer.addClass('border-blue-900 bg-slate-200');
                imageContainer.removeClass('bg-transparent');
            });

            imageContainer.on('dragleave', function() {
                imageContainer.removeClass('border-blue-900 bg-slate-200');
                imageContainer.removeClass('bg-transparent');
            });

            imageContainer.on('drop', function(event) {
                event.preventDefault();
                imageContainer.removeClass('border-blue-900 bg-slate-200');

                const file = event.originalEvent.dataTransfer.files[0];
                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (validImageTypes.includes(file.type)) {
                        if (file.size <= 2 * 1024 * 1024) { // 2 MB
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImage.attr('src', e.target.result);
                                previewImageContainer.removeClass('hidden');
                                imagePlaceholder.addClass('hidden');
                                imageButtons.removeClass('hidden');
                            };
                            reader.readAsDataURL(file);
                            temporaryImageFile = file;
                        } else {
                            toastr.error('File size should not exceed 2MB.');
                        }
                    } else {
                        toastr.error(
                            'Invalid file type. Please upload an image in JPEG, JPG, or PNG format.');
                    }
                }
            });

            imageInput.on('change', function() {
                const file = imageInput[0].files[0];
                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (validImageTypes.includes(file.type)) {
                        if (file.size <= 2 * 1024 * 1024) { // 2 MB
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImage.attr('src', e.target.result);
                                previewImageContainer.removeClass('hidden');
                                imagePlaceholder.addClass('hidden');
                                imageButtons.removeClass('hidden');
                            };
                            reader.readAsDataURL(file);
                            temporaryImageFile = file;
                        } else {
                            toastr.error('File size should not exceed 2MB.');
                        }
                    } else {
                        toastr.error(
                            'Invalid file type. Please upload an image in JPEG, JPG, or PNG format.');
                    }
                }
            });

            removeImage.on('click', function() {
                previewImageContainer.addClass('hidden');
                imagePlaceholder.removeClass('hidden');
                imageInput.val('');
                imageInput.click();
            });

            quantity.on('input', function() {
                if (this.value <= 0) {
                    $(this).val(1);
                }
            });
        });
    </script>

</x-dashboard.layout>

</html>
