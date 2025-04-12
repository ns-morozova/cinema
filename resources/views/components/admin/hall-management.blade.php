<section class="conf-step">
    <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
    </header>
    <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Доступные залы:</p>
        <ul class="conf-step__list">
            @foreach ($halls as $hall)
                <li>{{$hall['name']}}
                    <button class="conf-step__button conf-step__button-trash" data-id="{{ $hall['id'] }}"
                        data-name="{{ $hall['name'] }}"></button>
                </li>
            @endforeach
        </ul>
        <button id="create-hall-btn" class="conf-step__button conf-step__button-accent">Создать зал</button>
    </div>
</section>

<div id="create-hall-modal" class="modal" style="display:none;">
    <div class="modal__overlay"></div>
    <div class="modal__window">
        <h3 class="modal__title">Создать новый зал</h3>
        <form id="create-hall-form" action="{{ route('admin.cinema-halls.store') }}" method="POST">
            @csrf
            <label class="modal__label">Название зала:
                <input type="text" name="name" class="modal__input" required>
            </label>
            <label class="modal__label">Рядов, шт:
                <input type="number" name="rows" class="modal__input" min="1" required>
            </label>
            <label class="modal__label">Мест в ряду, шт:
                <input type="number" name="seats_per_row" class="modal__input" min="1" required>
            </label>
            <div class="modal__actions">
                <button type="button" id="cancel-create-hall"
                    class="conf-step__button conf-step__button-regular">Отмена</button>
                <button type="submit" id="save-create-hall"
                    class="conf-step__button conf-step__button-accent">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<div id="delete-hall-modal" class="modal" style="display: none;">
    <div class="modal__overlay"></div>
    <div class="modal__window">
        <h3 class="modal__title">Удалить зал</h3>
        <p id="delete-hall-text" class="modal__label">Вы уверены, что хотите удалить зал?</p>
        <form id="delete-hall-form" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal__actions">
                <button type="button" id="cancel-delete-hall"
                    class="conf-step__button conf-step__button-regular">Отмена</button>
                <button type="submit" class="conf-step__button conf-step__button-accent">Удалить</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('create-hall-modal');
        const openBtn = document.getElementById('create-hall-btn');
        const cancelBtn = document.getElementById('cancel-create-hall');

        const deleteModal = document.getElementById('delete-hall-modal');
        const deleteForm = document.getElementById('delete-hall-form');
        const deleteText = document.getElementById('delete-hall-text');
        const cancelDeleteBtn = document.getElementById('cancel-delete-hall');

        const closeModal = () => modal.style.display = 'none';
        const openModal = () => modal.style.display = 'block';

        openBtn.addEventListener('click', openModal);
        cancelBtn.addEventListener('click', closeModal);

        document.querySelectorAll('.conf-step__button-trash').forEach(button => {
            button.addEventListener('click', () => {
                const hallId = button.getAttribute('data-id');
                const hallName = button.getAttribute('data-name');

                deleteText.textContent = `Вы уверены, что хотите удалить зал «${hallName}»?`;
                deleteForm.action = `/admin/cinema-halls/${hallId}`;

                deleteModal.style.display = 'block';
            });
        });

        cancelDeleteBtn.addEventListener('click', () => {
            deleteModal.style.display = 'none';
        });
    });
</script>