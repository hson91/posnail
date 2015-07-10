<section class="page-content">
	<div class="container">
		
		<div class="row">
			<div class="col-md-6" style="float: inherit; margin: 0 auto;">
                <?php if(Yii::app()->user->hasFlash('mss')) echo Yii::app()->user->getFlash('mss');?>
				<div class="box">
					<h3>Đăng nhập</h3>
					<form action="<?php echo Yii::app()->baseUrl.'/guest/login'?>" method="post">
						<div class="form-group">
							<label>Tên đăng nhập </label>
							<input placeholder="&#xf007;" type="text" name="Guest[username]" class="form-control" />
						</div>
						<div class="form-group">
							<div class="clearfix">
								<label class="pull-left"> Mật khẩu </label>
							</div>
							<input type="password" name="Guest[password]" placeholder="&#xf023;" class="form-control" />
						</div>
						<button type="submit" class="btn btn-primary btn-inline">Login</button>
                        <a href="#"  class="btn btn-primary btn-inline" >Không cần tài khoản</a>
					</form>
				</div>
			</div>
		</div>


	</div>
</section>