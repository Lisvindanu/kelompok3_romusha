<x-layout>

    <x-navbar></x-navbar>
    <div class="min-h-screen flex flex-col items-center px-4 md:px-10 pt-10 bg-neutral-900 text-gray-300">
        <div class="container grid grid-cols-1 md:grid-cols-12 gap-6 pt-4 pb-16 mt-7">
            <x-profile-sidebar :activePage="'profile'" :userData="$userData" />

            <div class="col-span-12 md:col-span-9">
                <div class="bg-neutral-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-yellow-400 mb-6 font-pixelify">Profil Pribadi</h2>

                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded-md mb-4">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form
                        action="{{ route('update.profile') }}"
                        method="POST"
                        class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="fullname" class="block text-lg text-gray-400 font-pixelify">Nama</label>
                                <input
                                    id="fullname"
                                    name="fullname"
                                    type="text"
                                    required
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    value="{{ old('fullname', $userData['fullname']) }}"
                                    readonly
                                />
                            </div>

                            <div>
                                <label for="email" class="block text-lg text-gray-400 font-pixelify">Email</label>
                                <input
                                    id="email"
                                    type="email"
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2 w-full border border-gray-300"
                                    value="{{ old('email', $userData['email']) }}"
                                    disabled
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="address" class="block text-lg text-gray-400 font-pixelify">Alamat</label>
                                <input
                                    id="address"
                                    name="address"
                                    type="text"
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Alamat"
                                    value="{{ old('address', $userData['address'] ?? '') }}"
                                />
                            </div>

                            <div>
                                <label for="phoneNumber" class="block text-lg text-gray-400 font-pixelify">Nomor Handphone</label>
                                <input
                                    id="phoneNumber"
                                    name="phoneNumber"
                                    type="text"
                                    class="bg-neutral-900 text-gray-200 text-lg rounded-md px-6 py-4 mt-2 w-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition-all duration-300"
                                    placeholder="Masukkan Nomor Handphone"
                                    value="{{ old('phoneNumber', $userData['phoneNumber'] ?? '') }}"
                                />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <label class="block text-lg text-gray-400 font-pixelify">Foto Profil</label>
                            <div class="mt-2 flex items-center gap-x-3">
                                @if(str_contains($userData['imageUrl'], 'googleusercontent'))
                                    <img src="{{ $userData['imageUrl'] }}"
                                         alt="Google profile photo"
                                         class="h-24 w-24 rounded-full object-cover"/>
                                @else
                                    <img src="{{ 'https://virtual-realm.my.id' . $userData['imageUrl'] }}"
                                         alt="Uploaded profile photo"
                                         class="h-24 w-24 rounded-full object-cover"/>
                                @endif


                                <input type="file"
                                       id="imageUrl"
                                       name="imageUrl"
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-400
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-yellow-500 file:text-red-800
                              hover:file:bg-yellow-400
                              file:cursor-pointer cursor-pointer"/>
                            </div>
                            @error('imageUrl')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button
                                type="submit"
                                id="saveButton"
                                class="bg-yellow-500 text-red-800 py-2 px-6 rounded-md font-medium hover:bg-yellow-400 transition font-pixelify">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-layout>
