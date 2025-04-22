<div class="language-switcher">
    <div class="language-dropdown">
        <button class="language-button">
            <span class="language-current"><?php echo isLangActive('es') ? 'ES' : 'EN'; ?></span>
        </button>
        <div class="language-dropdown-content">
            <a href="<?php echo getLangUrl('es'); ?>" class="<?php echo isLangActive('es') ? 'active' : ''; ?>">
                <?php echo __('lang_es'); ?>
            </a>
            <a href="<?php echo getLangUrl('en'); ?>" class="<?php echo isLangActive('en') ? 'active' : ''; ?>">
                <?php echo __('lang_en'); ?>
            </a>
        </div>
    </div>
</div>
