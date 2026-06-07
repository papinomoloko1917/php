<h1>Home page</h1>
<form action="/add_product" method="post">
  <div class="mb-3">
    <label for="title" class="form-label">Название</label>
    <input name="title" type="text" class="form-control" id="title" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
  <label for="description" class="form-label">Описание товара</label>
  <textarea name="description" class="form-control" id="description" rows="3"></textarea>
</div>
  <div class="mb-3">
    <label for="priceProduct" class="form-label">Цена</label>
    <input name="price" type="number" step="0.01" class="form-control" id="priceProduct">
  </div>
  <button type="submit" class="btn btn-primary">Создать</button>
</form>
