<?php $class_name = count($errors) ? " form--invalid" : ""; ?>
<form class="form form--add-lot container<?= $class_name; ?>" action="add.php"
    method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $class_name = isset($errors['lot-name']) ? " form__item--invalid" : "";
        $value = isset($new_lot['lot-name']) ? $new_lot['lot-name'] : ""; ?>
        <div class="form__item<?= $class_name; ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= $value; ?>"
                >
            <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $class_name = isset($errors['category']) ? " form__item--invalid" : "";
        $value = isset($new_lot['category']) ? $new_lot['category'] : ""; ?>
        <div class="form__item<?= $class_name; ?>">
            <label for="category">Категория</label>
            <select id="category" name="category">
            <?php foreach ($data as $key => $val):?>
            <option value="<?= $val['id']; ?>" <?php if ($val['id']==$value): echo "selected" ; endif; ?>>
                <?= $val['name']; ?>
            </option>
            <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <?php $class_name = isset($errors['message']) ? " form__item--invalid" : "";
    $value = isset($new_lot['message']) ? $new_lot['message'] : ""; ?>
    <div class="form__item form__item--wide<?=$class_name; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$value; ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <?php $class_name = isset($errors['lot_img']) ? " form__item--invalid" : "";
    $value = isset($new_lot['lot_img']) ? $new_lot['lot_img'] : ""; ?>
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
            <input class="visually-hidden" type="file" id="photo2" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
    </div>
    <div class="form__container-three">
        <?php $class_name = isset($errors['lot-rate']) ? " form__item--invalid" : "";
        $value = isset($new_lot['lot-rate']) ? $new_lot['lot-rate'] : ""; ?>
        <div class="form__item form__item--small<?=$class_name; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$value; ?>" >
            <span class="form__error">Введите начальную цену</span>
        </div>
        <?php $class_name = isset($errors['lot-step']) ? " form__item--invalid" : "";
        $value = isset($new_lot['lot-step']) ? $new_lot['lot-step'] : ""; ?>
        <div class="form__item form__item--small<?=$class_name; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=$value; ?>" >
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <?php $class_name = isset($errors['lot-date']) ? " form__item--invalid" : "";
        $value = isset($new_lot['lot-date']) ? $new_lot['lot-date'] : ""; ?>
        <div class="form__item<?=$class_name; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$value; ?>" >
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
