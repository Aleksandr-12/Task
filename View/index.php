  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Задачи</h1>
	<?php if(!$_SESSION['name']):?>
	<a href="/auth" class="btn mt-2 mb-2 btn-primary" >
		Авторизоваться
	</a>
		<?php else:?>
			<a class="btn btn-primary"  href="/admin">Админ панель</a>
			<a class="btn btn-danger"  href="/outer">Выйти</a>
			
		<?php endif;?>
		<?php if($_SESSION['success']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['success'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['success']);?>
		
		<?php if($_SESSION['exit']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['exit'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['exit']);?>
		<?php if($_SESSION['error']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['error'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['error']);?>
		
		
		<?php if(getFlash('task')):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo getFlash('task');?>
			</div>
		<?php  endif;?>
		<?php delFlash('task');?>
		
<?php if($this->data):?>
	<form class="d-flex justify-content-end" id="reset" method='POST' >
		<input type="submit" class="btn btn-primary" value="сбросить"  name="reset">
	</form>
		
		<table class="table mt-2 table-striped">
		<thead>
	  
		<tr>
		  <th scope="col">
			  <div class="form-group d-flex align-items-start">
				#
			  </div>
		  </th>
		  <th scope="col">
			<div class="form-group d-flex align-items-end">
			
				<div class="mr-2">
					Имя
				</div>
				<form id="sortForm"  method='POST' onchange="document.getElementById('sortForm').submit()">
					<select class="form-control ml-2"  name="sortName" >
						  <option value="" >по умолчанию</option>
						  <option value="asc" <?php if($_SESSION['sort-name'] == 'asc') { echo 'selected';}?>>По возрастанию</option>
						  <option value="desc" <?php if($_SESSION['sort-name'] == 'desc') { echo 'selected';}?>>По убыванию</option>
					  </select>
				</form>
			
			</div>
		  </th>
		  <th scope="col">
			<div class="form-group d-flex ">
				<div class="mr-2 d-flex align-items-end">
					email
				</div>
				<form id="sortEmail" method='POST' onchange="document.getElementById('sortEmail').submit()">
					<select class="form-control ml-2"  name="sortEmail" >
							<option value="" >по умолчанию</option>
						  <option value="asc" <?php if($_SESSION['sort-email'] == 'asc') { echo 'selected';}?>>По возрастанию</option>
						  <option value="desc" <?php if($_SESSION['sort-email'] == 'desc') { echo 'selected';}?>>По убыванию</option>
					  </select>
				</form>
			</div>
		  </th>
			<th scope="col">
				<div class="form-group d-flex">
					<div class="mr-2 d-flex">
						Текст задачи
					</div>
				</div>
			</th>
			<th scope="col">
				<div class="form-group d-flex align-items-end">
				
					<div class="mr-2">
						Статус
					</div>
					<form id="sortStatus" method='POST' onchange="document.getElementById('sortStatus').submit()">
						<select class="form-control d-flex  align-items-end ml-2"  name="sortStatus">
								<option value="" >по умолчанию</option>
							  <option value="asc" <?php if($_SESSION['sort-status'] == 'asc') { echo 'selected';}?>>По возрастанию</option>
							  <option value="desc" <?php if($_SESSION['sort-status'] == 'desc') { echo 'selected';}?>>По убыванию</option>
						  </select>
					</form>
				</div>
			</th>
			
			
			
		</tr>
		
	  </thead>
	  
		  <tbody>
		  <?php foreach($this->data as $value){?>
			<tr>
			  <th scope="row"><?php echo $value['id']; ?></th>
			  <td  style="word-break: break-all;"><?php h($value['name']); ?></td>
			  <td style="width:200px;word-break: break-all;"><?php h($value['email']); ?></td>
			  <td style="width:250px;word-break: break-all;"><?php h($value['text']); ?></td>
			  <td class="d-flex justify-content-between">
			  <div class="">
				<?= $value['status'] ? "<div class='btn btn-success'>Выполнено</div>": "<div class='btn btn-primary'>Не выполнено</div>"?>
			  </div>
			   <?= $value['updated_at'] ? "<div class='alert alert-info' role='alert'>Отредактировано <br>администратором</div>": null?></td>
			</tr>
		  <?php }?>
	   
		  </tbody>
		  <?php else:?>
			<div class="alert mt-2 alert-primary" role="alert">
			  Задач пока нет!
			</div>
		  <?php endif;?>
		</table>
	
	<?php if($pagination->countPages > 1):?>
			<?=$pagination?>
	<?php endif;?>
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
	  Создать задачу
	</button>
  </div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Создание задачи</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form action="/manager.php"  method="POST">
      <div class="modal-body">
		  <div class="form-group">
			<label for="exampleInputName">Имя</label>
			<input name="name" type="text" class="form-control"  aria-describedby="exampleInputName" placeholder="Имя" required>
			
		 </div>
		  <div class="form-group">
			<label for="emailForm">E-mail</label>
			<input id="emailForm" name="email" type="email" class="form-control" placeholder="email" required>
		  </div>
		
		 <div class="form-group">
			<label for="exampleFormControlTextarea1">Описание задачи</label>
			<textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
        <button type="submit" class="btn btn-primary">Отправить</button>
      </div>
	  </form>
    </div>
  </div>
</div>




