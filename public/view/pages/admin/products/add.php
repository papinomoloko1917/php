<h3>Страница добавления товаров</h3>

<form action="/admin/products/add" method="post">
  <div class="mb-3">
    <label for="tittleProduct" class="form-label">Название товара</label>
    <input name="tittleProduct" type="text" class="form-control" id="tittleProduct" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">Добавьте название товара</div>
  </div>
  <div class="mb-3">
    <label for="descriptionProduct" class="form-label">Описание товара</label>
    <textarea name="descriptionProduct" type="text" class="form-control" id="descriptionProduct" aria-describedby="emailHelp" rows="3"></textarea>
    <div id="emailHelp" class="form-text">Добавьте описание товара</div>
  </div>
  <div class="mb-3">
    <label for="priceProduct" class="form-label">Цена товара</label>
    <input name="priceProduct" type="text" class="form-control" id="priceProduct" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">Добавьте цену товара</div>
  </div>
  <div class="mb-3">
    <label for="quantityProduct" class="form-label">Количество товара</label>
    <input name="quantityProduct" type="text" class="form-control" id="quantityProduct" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">Добавьте количество товара</div>
  </div>
  <button type="submit" class="btn btn-primary">Добавить</button>
</form>
