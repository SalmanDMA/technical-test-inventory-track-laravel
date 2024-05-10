<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-head title="Dashboard Profile" />

<x-dashboard.layout>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 mb-6">
        <div class="bg-white rounded-sm border border-slate-300 shadow-lg p-6">
            <header class="border-b border-slate-200 pb-4">
                <p class="font-poppins text-slate-950 font-semibold text-xl">
                    <i class="fa-solid fa-address-card bg-gray-300 text-gray-600 p-2 rounded-full mr-2"></i>
                    Edit Profile
                </p>
            </header>
            <div class="pt-4">
                <form class="flex flex-col gap-4" action="{{ route('dashboard.profile.post.update') }}" method="POST">
                    @csrf

                    <div class="hidden">
                        <x-input-field name="user_id" labelName="id" placeholder="Enter your id here..." type="text"
                            requiredInput="true" value="{{ auth()->user()->id }}" />
                    </div>

                    <x-input-field name="name" labelName="Name" placeholder="Enter your name here..." type="text"
                        requiredInput="true" value="{{ auth()->user()->name }}" />
                    <x-input-field name="email" labelName="Email" placeholder="Enter your email here..."
                        type="text" requiredInput="true" value="{{ auth()->user()->email }}" />

                    <x-input-field name="address" labelName="Address" placeholder="Enter your address here..."
                        type="text" requiredInput="true" value="{{ auth()->user()->address ?? '-' }}" />

                    <x-input-field name="phone" labelName="Phone" placeholder="Enter your phone here..."
                        type="text" requiredInput="true" value="{{ auth()->user()->phone ?? '-' }}" />


                    <div class="mt-4">
                        <button type="submit"
                            class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 text-white font-gelasio">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-white rounded-sm border border-slate-300 shadow-lg p-6">
            <header class="border-b border-slate-200 pb-4">
                <p class="font-poppins text-slate-950 font-semibold text-xl">
                    <i class="fa-solid fa-id-badge bg-gray-300 text-gray-600 p-2 rounded-full mr-2"></i>
                    Profile
                </p>
            </header>
            <div class="pt-4 flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <div class="relative">
                        <img src="{{ auth()->user()->avatar == null ? asset('images/avatar.jpeg') : Storage::url('photo-users/' . auth()->user()->avatar) }}"
                            alt="{{ auth()->user()->name }}"
                            class="rounded-full size-48 mx-auto object-cover object-center" id="profileImage" />
                        <div class="hidden" id="previewImageContainer">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <img id="previewImage"
                                    class="rounded-full size-48 mx-auto object-cover object-center" />
                                <div class="mb-4 flex gap-2" id="imageButtons">
                                    <button type="button" id="removeImage"
                                        class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-1 focus:ring-gray-600 disabled:pointer-events-none disabled:opacity-50 font-gelasio">
                                        Choose image again
                                    </button>
                                    <form id="saveImageForm">
                                        <button type="submit" id="saveImage"
                                            class="inline-flex items-center gap-x-2 rounded-lg border border-transparent bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-1 focus:ring-gray-600 disabled:pointer-events-none disabled:opacity-50 font-gelasio">
                                            Save image
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <label id="imageLabel" for="imageInput"
                            class="absolute bottom-[10px] right-[calc(50%-80px)] p-2 bg-primary rounded-full size-10 flex justify-center items-center cursor-pointer">
                            <input type="file" accept="image/jpeg,image/png,image/jpg" class="hidden" id="imageInput"
                                name="imageInput">
                            <i class="fa-solid fa-camera text-xl text-white"></i>
                        </label>
                    </div>
                    <p
                        class="bg bg-primary text-white font-gelasio font-semibold rounded-xl flex justify-center items-center px-4 py-2 max-w-max mx-auto">
                        {{ auth()->user()->role }}
                    </p>
                </div>
                <div class="flex flex-col">
                    <h3 class="font-poppins text-slate-950 font-semibold text-lg">Name</h3>
                    <p class="text-slate-500 font-gelasio text-lg">{{ auth()->user()->name }}</p>
                </div>
                <hr class="border-slate-200">
                <div class="flex flex-col">
                    <h3 class="font-poppins text-slate-950 font-semibold text-lg">Email</h3>
                    <p class="text-slate-500 font-gelasio text-lg">{{ auth()->user()->email }}</p>
                </div>
                <hr class="border-slate-200">
                <div class="flex flex-col">
                    <h3 class="font-poppins text-slate-950 font-semibold text-lg">Address</h3>
                    <p class="text-slate-500 font-gelasio text-lg">{{ auth()->user()->address ?? '-' }}</p>
                </div>
                <hr class="border-slate-200">
                <div class="flex flex-col">
                    <h3 class="font-poppins text-slate-950 font-semibold text-lg">Phone Number</h3>
                    <p class="text-slate-500 font-gelasio text-lg">{{ auth()->user()->phone ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-sm border border-slate-300 shadow-lg p-6">
        <header class="border-b border-slate-200 pb-4">
            <p class="font-poppins text-slate-950 font-semibold text-xl">
                <i class="fa-solid fa-lock bg-gray-300 text-gray-600 p-2 rounded-full mr-2"></i>
                Change Password
            </p>
        </header>
        <div class="pt-4">
            <form class="flex flex-col gap-4" action="{{ route('dashboard.profile.password.post.update') }}"
                method="POST">
                @csrf

                <div class="hidden">
                    <x-input-field name="user_id" labelName="id" placeholder="Enter your id here..." type="text"
                        requiredInput="true" value="{{ auth()->user()->id }}" />
                </div>

                <x-input-field name="new_password" labelName="New Password"
                    placeholder="Enter your new password here..." type="password" />
                <x-input-field name="confirm_password" labelName="Confirm Password"
                    placeholder="Enter your confirm password here..." type="password" />


                <div class="mt-4">
                    <button type="submit"
                        class="flex w-full justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 text-white font-gelasio">
                        Change Password
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            const imageInput = $('#imageInput');
            const previewImageContainer = $('#previewImageContainer');
            const previewImage = $('#previewImage');
            const imageLabel = $('#imageLabel');
            const profileImage = $('#profileImage');
            const removeImage = $('#removeImage');
            const saveImage = $('#saveImage');
            const imageButtons = $('#imageButtons');
            let temporaryImageFile = null;

            imageInput.on('change', function() {
                const file = imageInput[0].files[0];
                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (validImageTypes.includes(file.type)) {
                        if (file.size <= 2 * 1024 * 1024) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewImage.attr('src', e.target.result);
                                previewImage.attr('alt', e.target.result);
                                profileImage.addClass('hidden');
                                imageLabel.addClass('hidden');
                                previewImageContainer.removeClass('hidden');
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
                profileImage.removeClass('hidden');
                imageLabel.removeClass('hidden');
                imageInput.click();
            });

            saveImage.on('click', function() {
                previewImageContainer.removeClass('hidden');

                if (temporaryImageFile) {
                    $('#saveImageForm').on('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData();
                        formData.append('avatar', temporaryImageFile);
                        formData.append('user_id', "{{ auth()->user()->id }}");
                        formData.append('oldAvatar', "{{ auth()->user()->avatar }}");
                        formData.append('update_image', true);

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            type: 'POST',
                            url: "{{ route('dashboard.profile.post.update') }}",
                            data: formData,
                            processData: false,
                            contentType: false,
                            enctype: 'multipart/form-data',
                            success: function(response) {
                                if (response.success) {
                                    toastr.success(response.message);
                                    setTimeout(() => {
                                        window.location.href =
                                            "{{ route('dashboard.profile') }}";
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
                } else {
                    toastr.error('Image is required, please upload an image first.');
                }
            });
        });
    </script>
</x-dashboard.layout>

</html>
