<div class="container">
		 <div class="form-group">
			<a href="/"><< Назад</a>
		 </div>
		 <?php if($_SESSION['error']):?>
		 <div class="alert  alert-danger" role="alert">
			<?php echo $_SESSION['error'];?>
		</div>
		<?php  endif;?>
		<?php unset($_SESSION['error']);?>
		<form  method="POST">
		  <div class="form-group">
			<label for="name">Имя</label>
			<input name="name" type="text" class="form-control"  aria-describedby="nameHelp" placeholder="Имя" required>
		 </div>
		  <div class="form-group">
			<label for="password">Пароль</label>
			<input id="password" name="password" type="password" class="form-control" placeholder="password"required >
		  </div>
		  <input type="submit" name="auth" value="Отправить" class="btn btn-primary">
	</form>
	</div>