<?php $class_name = !empty($errors) ? " form--invalid" : ""; ?>
<form class="form container<?= $class_name; ?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>
    <?php $class_name = isset($errors['email']) ? " form__item--invalid" : "";
    ?>
    <div class="form__item<?= $class_name; ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="signup[email]" placeholder="Введите e-mail" value="<?=strip_tags($values['email'] ?? ''); ?>">
        <span class="form__error"><?=$errors['email']; ?></span>
    </div>
    <?php $class_name = isset($errors['password']) ? " form__item--invalid" : "";
    ?>
    <div class="form__item<?= $class_name; ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="password" name="signup[password]" placeholder="Введите пароль">
        <span class="form__error"><?=$errors['password']; ?></span>
    </div>
    <?php $class_name = isset($errors['name']) ? " form__item--invalid" : "";
    ?>
    <div class="form__item<?= $class_name; ?>">
        <label for="name">Имя*</label>
        <input id="name" type="text" name="signup[name]" placeholder="Введите имя" value="<?=strip_tags($values['name'] ?? ''); ?>">
        <span class="form__error"><?=$errors['name']; ?></span>
    </div>
    <?php $class_name = isset($errors['message']) ? " form__item--invalid" : "";
    ?>
    <div class="form__item<?= $class_name; ?>">
        <label for="message">Контактные данные*</label>
        <textarea id="message" name="signup[message]" placeholder="Напишите как с вами связаться"><?=strip_tags($values['message'] ?? ''); ?></textarea>
        <span class="form__error"><?=$errors['message']; ?></span>
    </div>
    <?php $class_name = isset($errors['avatar']) ? " form__item--invalid" : "";
    ?>
    <div class="form__item form__item--file form__item--last <?=$class_name; ?>">
        <label>Аватар</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="avatar" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=$errors['avatar']; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>
