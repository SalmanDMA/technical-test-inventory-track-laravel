<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Users" />

<x-dashboard.layout>
    <div class="mx-auto max-w-screen-2xl">
        <div class="mb-6">
            <a href="{{ route('dashboard.users') }}"
                class="text-slate-400 hover:text-slate-500 mb-4 inline-block font-gelasio">
                <i class="fa-solid fa-arrow-left"></i>
                Back
            </a>
            <h2 class="text-3xl font-bold text-slate-950 font-poppins">
                Form Layout Update User
            </h2>
        </div>

        <div class="flex flex-col gap-9">
            <div class="rounded-sm border border-slate-300 bg-white shadow-lg">
                <form id="userForm" class="py-4 px-6 flex flex-col gap-4">

                    <x-input-field name="name" labelName="Name" placeholder="Enter your name here..." type="text"
                        requiredInput="true" value="{{ $user->name }}" />
                    <x-input-field name="email" labelName="Email" placeholder="Enter your email here..."
                        type="text" requiredInput="true" value="{{ $user->email }}" />

                    <div>
                        <label for="role" class="mb-3 block text-sm font-medium text-slate-950 font-poppins">
                            Role<span class="text-red-500">*</span>
                        </label>

                        <div class="relative z-10 bg-transparent">
                            <select name="role" id="role"
                                class="relative z-10 appearance-none w-full rounded-lg border-[1.5px] border-primary bg-transparent px-5 py-3 font-normal text-slate-950 outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-slate-300 font-gelasio"
                                value="{{ $user->role }}">
                                <option value="" class="text-body">
                                    Select role
                                </option>
                                <option value="admin" class="text-body"
                                    @if ($user->role == 'admin') selected @endif>admin</option>
                                <option value="user" class="text-body"
                                    @if ($user->role == 'user') selected @endif>user</option>
                            </select>
                            <span class="absolute right-4 top-1/2 z-30 -translate-y-1/2">
                                <i class="fa-solid fa-chevron-down text-xl text-slate-950"></i>
                            </span>
                        </div>
                    </div>

                    <x-input-field name="address" labelName="Address" placeholder="Enter your address here..."
                        type="text" requiredInput="true" value="{{ $user->address }}" />

                    <x-input-field name="phone" labelName="Phone" placeholder="Enter your phone here..."
                        type="text" requiredInput="true" value="{{ $user->phone }}" />

                    <div class="flex flex-col gap-2">
                        <p class="mb-2 block text-sm font-medium text-slate-950 font-poppins">
                            Avatar
                        </p>
                        <div id="imageContainer"
                            class="flex items-center justify-center rounded-lg border-2 border-dashed border-primary bg-transparent p-8 transition duration-300 ease-in-out min-h-[300px]">
                            <label for="imageInput" class="h-full w-full cursor-pointer">
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
                            Update User
                        </button>
                    </div>
                </form>
            </div>
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

            @if ($user->avatar)
                imageContainer.removeClass('hidden');
                imagePlaceholder.addClass('hidden');
                previewImageContainer.removeClass('hidden');
                imageButtons.addClass('hidden');
                previewImage.attr('src', "{{ Storage::url('photo-users/' . $user->avatar) }}");
            @endif

            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                const name = $('#name').val();
                const email = $('#email').val();
                const address = $('#address').val();
                const phone = $('#phone').val();
                const role = $('#role').val();

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

                if (!email) {
                    toastr.error('Email is required');
                    $('#email').focus();
                    return;
                }

                if (!/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
                    toastr.error('Email is not valid');
                    $('#email').focus();
                    return;
                }

                if (!address) {
                    toastr.error('Address is required');
                    $('#address').focus();
                    return;
                }

                if (!phone) {
                    toastr.error('Phone is required');
                    $('#phone').focus();
                    return;
                }

                if (!role) {
                    toastr.error('Role is required');
                    $('#role').focus();
                    return;
                }

                imageContainer.removeClass('border-primary');


                const formData = new FormData();
                formData.append('user_id', "{{ $user->id }}");
                formData.append('name', name);
                formData.append('email', email);
                formData.append('address', address);
                formData.append('phone', phone);
                formData.append('role', role);
                if (temporaryImageFile !== null) {
                    formData.append('avatar', temporaryImageFile);
                    formData.append('oldAvatar', "{{ $user->avatar }}");
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: "{{ route('dashboard.users.add.post.update') }}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(() => {
                                window.location.href =
                                    "{{ route('dashboard.users') }}";
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
        });
    </script>

</x-dashboard.layout>

</html>
