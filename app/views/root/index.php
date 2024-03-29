<div class="container" style="margin-top: 32px;">
  <div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1 class="display-4">一生の思い出に石川の名産品を</h1>
      <div  class="lead">
        <p>本サイトでは石川の名産品を名前やジャンル別で調べて購入することが出来ます。</p>
        <p>あなたの好きなものはなんですか？</p>
      </div>
    </div>
  </div>
  <div style="display:flex; flex-direction:row; justify-content: space-between;">
    <div class="list-group" id="category-box" style="margin-right: 64px;">
        <div class="list-group-item" style="background-color: #f5f5f5;text-align:center">ジャンル一覧</div>
        <? foreach ($categorys as $category) { ?>
          <form id="search-form"action="/kit-web-application/search" method="get">
            <input type="hidden" name="tag" value=<? echo $category ?> >
            <input type="submit" class="list-group-item" value=<? echo $category ?> style="width:200px;">
          </form>
        <? } ?>
      </div>
      <div style="width: 60vw;">
        <h2 style="margin-bottom: 16px;">売れ筋の商品</h2>
        <div style="
          display: grid;
          margin-bottom: 64px;
          column-gap: 56px;
          grid-template-rows: auto;
          grid-template-columns: repeat(auto-fill, 14vw);
          row-gap: 48px;
          width: 100%;">
          <? foreach ($products as $product) { ?>
            <a class="card" style="width: 14vw; color: #212529;" href="/kit-web-application/products/<?= $product['id'] ?>">
              <img src="<?= $product['image_url'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
              <div class="card-body">
                <h5 class="card-title"><?= $product['name'] ?></h5>
                <p class="card-text"><?= $product['description'] ?></p>
                <p class="card-text"><small class="text-muted"><?= $product['price'] ?>円</small></p>
              </div>
            </a>
          <? } ?>
        </div>
      </div>
  </div>
</div>
