@extends('layouts.app')

@section('content')
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="bg-gradient-primary text-white p-4 text-center">
                    <div class="position-relative d-inline-block">
                        <img id="avatarPreview" src="" alt="Аватар" class="avatar-lg" onclick="document.getElementById('avatarInput').click()">
                        <button class="btn btn-light btn-sm rounded-circle position-absolute bottom-0 end-0 shadow-sm"
                                onclick="document.getElementById('avatarInput').click()" style="width: 32px; height: 32px;">
                            <i class="fas fa-camera fa-xs"></i>
                        </button>
                    </div>
                    <input type="file" id="avatarInput" class="d-none" accept="image/*" onchange="previewAvatar(this)">
                    <h3 id="displayUsername" class="fw-bold mt-3 mb-1"></h3>
                    <p class="text-white-50 mb-0"><i class="fas fa-calendar-alt me-1"></i>Зарегистрирован: 15.03.2024</p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="fw-bold mb-0"><i class="fas fa-edit text-primary me-2"></i>Редактировать профиль</h4>
                    <p class="text-muted small mt-2">Обновите информацию о себе</p>
                </div>
                <div class="card-body p-4">
                    <form id="profileForm" onsubmit="saveProfile(event)">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Имя пользователя (логин)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user"></i></span>
                                <input type="text" id="usernameInput" class="form-control border-0 bg-light" placeholder="Введите логин">
                            </div>
                            <div id="usernameError" class="text-danger small mt-1 d-none">Логин не может быть пустым</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">О себе</label>
                            <textarea id="bioInput" class="form-control border-0 bg-light" rows="4" placeholder="Расскажите о себе..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">Пол</label>
                            <div class="d-flex gap-3">
                                <button type="button" id="genderMale" class="btn btn-outline-primary rounded-pill px-4 py-2 gender-btn" onclick="selectGender('male')">
                                    <i class="fas fa-mars me-2"></i>Мужской
                                </button>
                                <button type="button" id="genderFemale" class="btn btn-outline-primary rounded-pill px-4 py-2 gender-btn" onclick="selectGender('female')">
                                    <i class="fas fa-venus me-2"></i>Женский
                                </button>
                            </div>
                            <input type="hidden" id="genderValue">
                        </div>

                        <div id="saveMessage" class="alert alert-success border-0 rounded-3 d-none mb-4">
                            <i class="fas fa-check-circle me-2"></i>Профиль успешно обновлен!
                        </div>

                        <div class="d-flex gap-3 pt-2">
                            <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill">
                                <i class="fas fa-save me-2"></i>Сохранить изменения
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-lg {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: opacity 0.3s;
        }
        .avatar-lg:hover {
            opacity: 0.9;
        }
        .rounded-4 { border-radius: 1rem; }
        .rounded-3 { border-radius: 0.75rem; }
        .bg-gradient-primary { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); }
        .gender-btn.active {
            background-color: #4f46e5;
            border-color: #4f46e5;
            color: white;
        }
    </style>

    <script>
        let userData = {
            username: 'VADIM MOLODEC',
            bio: 'SUKA VADIM',
            gender: 'male',
            avatar: 'https://ui-avatars.com/api/?background=4f46e5&color=fff&size=120&bold=true&name=VADIM+MOLODEC'
        };

        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const avatarUrl = e.target.result;
                    document.getElementById('avatarPreview').src = avatarUrl;
                    userData.avatar = avatarUrl;
                    showTemporaryMessage('Аватар выбран. Нажмите "Сохранить изменения" для загрузки.');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function selectGender(gender) {
            const maleBtn = document.getElementById('genderMale');
            const femaleBtn = document.getElementById('genderFemale');
            const genderValue = document.getElementById('genderValue');

            if (gender === 'male') {
                maleBtn.classList.add('active');
                femaleBtn.classList.remove('active');
                genderValue.value = 'male';
                userData.gender = 'male';
            } else {
                femaleBtn.classList.add('active');
                maleBtn.classList.remove('active');
                genderValue.value = 'female';
                userData.gender = 'female';
            }
        }

        function saveProfile(event) {
            event.preventDefault();

            const usernameInput = document.getElementById('usernameInput');
            const newUsername = usernameInput.value.trim();
            const errorDiv = document.getElementById('usernameError');

            if (!newUsername) {
                errorDiv.classList.remove('d-none');
                return;
            }
            errorDiv.classList.add('d-none');
            userData.username = newUsername;

            const bioInput = document.getElementById('bioInput');
            userData.bio = bioInput.value.trim();

            const genderValue = document.getElementById('genderValue');
            userData.gender = genderValue.value;

            document.getElementById('displayUsername').textContent = userData.username;

            const messageDiv = document.getElementById('saveMessage');
            messageDiv.innerHTML = '<i class="fas fa-check-circle me-2"></i>Профиль успешно обновлен!';
            messageDiv.classList.remove('d-none');
            setTimeout(() => {
                messageDiv.classList.add('d-none');
            }, 3000);
        }

        function showTemporaryMessage(message) {
            const messageDiv = document.getElementById('saveMessage');
            messageDiv.innerHTML = `<i class="fas fa-info-circle me-2"></i>${message}`;
            messageDiv.classList.remove('d-none');
            setTimeout(() => {
                messageDiv.classList.add('d-none');
            }, 3000);
        }

        function loadData() {
            document.getElementById('usernameInput').value = userData.username;
            document.getElementById('bioInput').value = userData.bio;
            document.getElementById('genderValue').value = userData.gender;
            document.getElementById('displayUsername').textContent = userData.username;
            document.getElementById('avatarPreview').src = userData.avatar;

            if (userData.gender === 'male') {
                document.getElementById('genderMale').classList.add('active');
                document.getElementById('genderFemale').classList.remove('active');
            } else {
                document.getElementById('genderFemale').classList.add('active');
                document.getElementById('genderMale').classList.remove('active');
            }
        }

        loadData();
    </script>
@endsection
