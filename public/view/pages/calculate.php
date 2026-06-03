<form action="/calculate" method="post">
  <div class="mb-3">
    <label for="num1" class="form-label">Число №1</label>
    <input name="num1" type="number" class="form-control" id="num1">
    <!-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> -->
  </div>
  <div class="mb-3">
    <label for="num2" class="form-label">Число №2</label>
    <input name="num2" type="number" class="form-control" id="num2">
  </div>

  <button name="operation" value="+" type="submit" class="btn btn-primary">+</button>
  <button name="operation" value="-" type="submit" class="btn btn-primary">-</button>
  <button name="operation" value="/" type="submit" class="btn btn-primary">/</button>
  <button name="operation" value="*" type="submit" class="btn btn-primary">х</button>

  <div class="mt-3">
    <h5>Результат:</h5>
  </div>
</form>
