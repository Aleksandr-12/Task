  <div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Задачи</h1>
	
	<a class="btn btn-primary" href="/">На главную</a>
		<?php if($_SESSION['editTask']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['editTask'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['editTask']);?>
		
		<?php if($_SESSION['editStatus']):?>
			 <div class="alert mt-2 alert-success" role="alert">
				<?php echo $_SESSION['editStatus'];?>
			</div>
		<?php  endif;?>
		<?php unset($_SESSION['editStatus']);?>
    <table class="table table-striped">
	  <thead>
	  
		<tr>
		  <th scope="col">#</th>
		  <th scope="col" >Имя</th>
		  <th scope="col">email</th>
		  
		  <th scope="col">Текст задачи/Действия</th>
		  <th scope="col">Статус</th>
		</tr>
	  </thead>
  <?php if($this->data):?>
	  <tbody>
	  <?php foreach($this->data as $value){?>
		<tr>
		  <th scope="row"><?php echo $value['id']; ?></th>
		  <td style="width:150px;word-break: break-all;"><?php h($value['name']); ?></td>
		  <td><?php h($value['email']); ?></td>
			  
		  <td>
		  <form>
			<div class="form-group d-flex">
				<textarea cols='50'  type="text" name="task" class="form-control mr-2" placeholder="Описание"><?php  h($value['text']); ?>"</textarea>
				<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
				<button type="submit" class="d-flex align-self-start btn btn-danger">Edit</button>
			</div>
			</form>
		</td>
		  
		  <td><?= $value['status'] ? "<div class='btn btn-success'>выполнено</div>": "<a class='btn btn-primary' href='/admin?id=" . $value['id'] ."'><i class='fa fa-fw fa-eye'>Выполнить</i></a>"?></td>
		</tr>
	  <?php }?>
	   
	  </tbody>
 
  <?php endif;?>
</table>
 <?php if($pagination->countPages > 1):?>
			<?=$pagination?>
	<?php endif;?>
  </div>
</div>
<!-- Button trigger modal -->







