<?php $class_name = !empty($errors) ? " form--invalid" : ""; ?>
<form class="form form--add-lot container<?= $class_name; ?>" action="add.php"
    method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $class_name = isset($errors['lot-name']) ? " form__item--invalid" : "";
        $value = isset($lot['lot-name']) ? $lot['lot-name'] : ""; ?>
        <div class="form__item<?=$class_name; ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=strip_tags($value); ?>"
                >
            <span class="form__error"><?=$errors['lot-name']; ?></span>
        </div>
        <?php $class_name = isset($errors['category']) ? " form__item--invalid" : "";
        $value = isset($lot['category']) ? $lot['category'] : ""; ?>
        <div class="form__item<?= $class_name; ?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
                <?php foreach ($categories as $cat): ?>
                <option value="<?=$cat['id'] ?>"><?=$cat['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <?php $class_name = isset($errors['message']) ? " form__item--invalid" : "";
    $value = isset($lot['message']) ? $lot['message'] : ""; ?>
    <div class="form__item form__item--wide<?=$class_name; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=strip_tags($value); ?></textarea>
        <span class="form__error"><?=$errors['message']; ?></span>
    </div>
    <?php $class_name = isset($errors['lot_img']) ? " form__item--invalid" : "";
    $value = isset($lot['lot_img']) ? $lot['lot_img'] : ""; ?>
    <div class="form__item form__item--file <?=$class_name; ?>">
        <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="lot_img" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=$errors['lot_img']; ?></span>
    </div>
    <div class="form__container-three">
        <?php $class_name = isset($errors['lot-rate']) ? " form__item--invalid" : "";
        $value = isset($lot['lot-rate']) ? $lot['lot-rate'] : ""; ?>
        <div class="form__item form__item--small<?=$class_name; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=strip_tags($value); ?>" >
            <span class="form__error"><?=$errors['lot-rate']; ?></span>
        </div>
        <?php $class_name = isset($errors['lot-step']) ? " form__item--invalid" : "";
        $value = isset($lot['lot-step']) ? $lot['lot-step'] : ""; ?>
        <div class="form__item form__item--small<?=$class_name; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=strip_tags($value); ?>" >
            <span class="form__error"><?=$errors['lot-step']; ?></span>
        </div>
        <?php $class_name = isset($errors['lot-date']) ? " form__item--invalid" : "";
        $value = isset($lot['lot-date']) ? $lot['lot-date'] : ""; ?>
        <div class="form__item<?=$class_name; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$value; ?>" >
            <span class="form__error"><?=$errors['lot-date']; ?></span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
