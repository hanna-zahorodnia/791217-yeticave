<section class="lot-item container">
<h2><?= $lot['title']; ?></h2>
<div class="lot-item__content">
    <div class="lot-item__left">
        <div class="lot-item__image">
            <img src="<?= $lot['photo_path']; ?>" width="730" height="548" alt="Сноуборд">
        </div>
        <p class="lot-item__category">Категория: <span><?= $lot['name']; ?></span></p>
        <p class="lot-item__description"><?= $lot['description']; ?></p>
    </div>
    <div class="lot-item__right">
        <?php if(!empty($_SESSION['user']['name'])): ?>
            <div class="lot-item__state">
                <div class="lot-item__timer timer">
                    <?=showTimeLeft($lot['end_date']); ?>
                </div>
                <div class="lot-item__cost-state">
                    <div class="lot-item__rate">
                        <span class="lot-item__amount">Текущая цена</span>
                        <span class="lot-item__cost"><?=htmlspecialchars(formatPrice($lot['price']));?></span>
                    </div>
                    <div class="lot-item__min-cost">
                        Мин. ставка <span><?= $lot['bid_step']; ?></span>
                    </div>
                </div>
                <?php if(!$author_id && !$_SESSION['user']['bid'] && (strtotime($_SESSION['current_lot']['end_date']) > strtotime('now'))): ?>
                <form class="lot-item__form" action="bid.php" method="post">
                    <?php $class_name = !empty($_SESSION['current_lot']['errors']) ? " form__item--invalid" : ""; ?>
                    <p class="lot-item__form-item form__item <?=$class_name; ?>">
                        <label for="cost">Ваша ставка</label>
                        <input id="cost" type="text" name="cost" placeholder="<?=htmlspecialchars(formatPrice($lot['price']+$lot['bid_step']))?>">
                        <span class="form__error"><?=$_SESSION['current_lot']['errors']; ?></span>
                    </p>
                    <button type="submit" class="button">Сделать ставку</button>
                </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="history">
            <h3>История ставок (<span><?=$history['bids_count']; ?></span>)</h3>
            <table class="history__list">
                <?php foreach ($bid as $val): ?>
                <tr class="history__item">
                    <td class="history__name"><?=$val['name']; ?></td>
                    <td class="history__price"><?=formatPrice($val['amount']); ?></td>
                    <td class="history__time"><?=showDate($val['set_date']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</section>

