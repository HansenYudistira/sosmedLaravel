@extends('layouts.app')

@section('content')
    <h1>
        <span id="profileName">{{ $user->name }} Profile</span>
        <button id="editProfile" class="btn btn-primary btn-sm">Edit</button>
        <button id="saveProfile" class="btn btn-success btn-sm" style="display: none;">Simpan</button>
        <button id="cancelEdit" class="btn btn-secondary btn-sm" style="display: none;">Cancel</button>
    </h1>
    <img src="{{ $user->photo != null ? url('/images/' . $user->photo) : url('/images/nophoto.jpeg') }}" alt="Foto Profil" id="profilePhoto" style="max-width: 150px;">
    <div id="profileInfo">
        <p>Nama: <span id="userName">{{ $user->name }}</span></p>
        <p>Email: <span id="userEmail">{{ $user->email }}</span></p>
        <p>Jenis Kelamin: <span id="userGender">{{ $user->gender }}</span></p>
        <p>Nomor Telepon: <span id="userPhone">{{ $user->phone }}</span></p>
        <p>Tanggal Lahir: <span id="userBirthDate">{{ $user->birth_date }}</span></p>
        <p>Alamat: <span id="userAddress">{{ $user->address }}</span></p>
        <p>Minat: <span id="userMinat">{{ $user->minat }}</span></p>
        <p>Bio: <span id="userBio">{{ $user->bio }}</span></p>
    </div>

    <form id="editProfileForm" style="display: none;" enctype="multipart/form-data">
        <div>
            <label for="editPhoto">Ubah Foto Profil:</label>
            <input type="file" id="editPhoto" name="photo">
        </div>
        <div>
            <label for="editName">Nama:</label>
            <input type="text" id="editName" value="{{ $user->name }}">
        </div><br>
        <div>
            <label for="editEmail">Email:</label>
            <input type="email" id="editEmail" value="{{ $user->email }}">
        </div><br>
        <div>
            <label for="editGender">Jenis Kelamin:</label>
            <select id="editGender">
                <option value="Laki-Laki" {{ $user->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div><br>
        <div>
            <label for="editPhone">Nomor Telepon:</label>
            <input placeholder="081234567890"  type="text" id="editPhone" value="{{ $user->phone }}">
        </div><br>
        <div>
            <label for="editBirthDate">Tanggal Lahir:</label>
            <input type="date" id="editBirthDate" value="{{ $user->birth_date }}">
        </div><br>
        <div>
            <label for="editAddress">Alamat:</label>
            <input type="text" id="editAddress" value="{{ $user->address }}">
        </div><br>
        <div>
            <label for="editMinat">Minat:</label>
            <input type="text" id="editMinat" value="{{ $user->minat }}">
        </div><br>
        <div>
            <label for="editBio">Bio:</label>
            <input type="text" id="editBio" value="{{ $user->bio }}">
        </div><br>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('editProfile');
            const saveButton = document.getElementById('saveProfile');
            const cancelButton = document.getElementById('cancelEdit');
            const profileForm = document.getElementById('editProfileForm');
            const profileInfo = document.getElementById('profileInfo');
            const profileName = document.getElementById('profileName');
            const profilePhoto = document.getElementById('profilePhoto');

            const originalValues = {
                name: document.getElementById('userName').textContent,
                email: document.getElementById('userEmail').textContent,
                gender: document.getElementById('userGender').textContent,
                phone: document.getElementById('userPhone').textContent,
                birth_date: document.getElementById('userBirthDate').textContent,
                address: document.getElementById('userAddress').textContent,
                minat: document.getElementById('userMinat').textContent,
                bio: document.getElementById('userBio').textContent
            };

            editButton.addEventListener('click', function () {
                const confirmed = confirm('Apakah Anda yakin ingin mengedit profile?');
                if (confirmed) {
                    profileName.style.display = 'none';
                    editButton.style.display = 'none';
                    saveButton.style.display = 'inline';
                    cancelButton.style.display = 'inline';
                    profileForm.style.display = 'block';
                    profileInfo.style.display = 'none';
                }
            });

            saveButton.addEventListener('click', function () {
                const userId = {{ $user->id }};
                const formData = new FormData();
                formData.append('name', document.getElementById('editName').value);
                formData.append('email', document.getElementById('editEmail').value);
                formData.append('gender', document.getElementById('editGender').value);
                formData.append('phone', document.getElementById('editPhone').value);
                formData.append('birth_date', document.getElementById('editBirthDate').value);
                formData.append('address', document.getElementById('editAddress').value);
                formData.append('minat', document.getElementById('editMinat').value);
                formData.append('bio', document.getElementById('editBio').value);
                const photoInput = document.getElementById('editPhoto');
                if (photoInput && photoInput.files.length > 0) {
                    formData.append('photo', photoInput.files[0]);
                }
                
                fetch(`/profile/${userId}/edit`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN':  '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('userName').textContent = formData.get('name');
                    document.getElementById('userEmail').textContent = formData.get('email');
                    document.getElementById('userGender').textContent = formData.get('gender');
                    document.getElementById('userPhone').textContent = formData.get('phone');
                    document.getElementById('userBirthDate').textContent = formData.get('birth_date');
                    document.getElementById('userAddress').textContent = formData.get('address');
                    document.getElementById('userMinat').textContent = formData.get('minat');
                    document.getElementById('userBio').textContent = formData.get('bio');
                    if (data.photo) {
                        profilePhoto.src = '/images/' + data.photo;
                    }

                    profileName.style.display = 'inline';
                    profileForm.style.display = 'none';
                    profileInfo.style.display = 'block';
                    editButton.style.display = 'inline';
                    saveButton.style.display = 'none';
                    cancelButton.style.display = 'none';
                    alert(data.message);
                })
                .catch(error => {
                    console.error('There was an error!', error);
                    alert('Gagal mengedit profil. Silakan coba lagi.');
                });
            });

            cancelButton.addEventListener('click', function () {
                profileName.style.display = 'inline';
                profileForm.style.display = 'none';
                profileInfo.style.display = 'block';
                editButton.style.display = 'inline';
                saveButton.style.display = 'none';
                cancelButton.style.display = 'none';

                document.getElementById('editName').value = originalValues.name;
                document.getElementById('editEmail').value = originalValues.email;
                document.getElementById('editGender').value = originalValues.gender;
                document.getElementById('editPhone').value = originalValues.phone;
                document.getElementById('editBirthDate').value = originalValues.birth_date;
                document.getElementById('editAddress').value = originalValues.address;
                document.getElementById('editMinat').value = originalValues.minat;
                document.getElementById('editBio').value = originalValues.bio;
            });
        });
    </script>
@endsection
