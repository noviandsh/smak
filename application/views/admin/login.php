<div>
    <form action="<?=base_url('dataprocess/login')?>" method="post">
        <div class="form-group form-user">
            <input type="text" class="form-control" id="username" placeholder="Your Username" name="username">
        </div>
        <div class="form-group form-pass">
            <input type="password" class="form-control" id="password" placeholder="Your Password" name="password">
        </div>
        <a href="<?=base_url('admin/reset-password')?>"><small>forgot password?</small></a><br>
        <button>Login</button>
    </form><br><br>
    <?php
        if(isset($_SESSION['error'])){
            echo "<div class='alert alert-danger' role='alert'>".$_SESSION['error']."</div>";
        }
    ?>
</div>
