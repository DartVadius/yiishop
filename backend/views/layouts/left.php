<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Меню магазина', 'options' => ['class' => 'header']],
                    ['label' => 'Пользователи', 'icon' => 'file-code-o', 'url' => ['user/index'], 'active' => $this->context->id === 'user'],
                    ['label' => 'Shop', 'icon' => 'folder', 'items' => [
                        ['label' => 'Бренды', 'icon' => 'file-code-o', 'url' => ['shop/brand/index'], 'active' => $this->context->id === 'shop/brand'],
                        ['label' => 'Теги', 'icon' => 'file-code-o', 'url' => ['shop/tag/index'], 'active' => $this->context->id === 'shop/tag'],
                        ['label' => 'Категории', 'icon' => 'file-code-o', 'url' => ['shop/category/index'], 'active' => $this->context->id === 'shop/category'],
                    ],
//                    ['label' => 'Пользователи', 'icon' => 'file-code-o', 'url' => ['user/index'], 'active' => Yii::$app->controller->id === 'user'],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
