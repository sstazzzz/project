<table class="left_side_bar">
	<tr>
		<td>
			<div class="header_01">Авторизация</div>
			<div class="margin_bottom_20 "></div>
			<div class="unauth">
				<form action="#" method="POST">
					<input type="text" placeholder="Логин" name="login" size="10"  class="input-login" title="Введите логин" />
					<input type="password" placeholder="Пароль" name="password" size="10" class="input-password" 
					title="Введите пароль" />
					<input type="submit"  name="Sear" value="Войти" class="submit_button_input" 
					title="Войти" />
					<input type="submit"  onclick='funregistration(event)' name="reg" value="Регистрация" class="submit_button_reg" 
					title="Регистрация" />
				</form>
			</div>
			<div class="auth" style="display: none">
				<div class="authlogin"></div>
				<a href="" onclick='funlogout(event); return false;'>Выйти</a>
			</div>
			<div class="margin_bottom_10 horizontal_divider"></div>
			<div class="margin_bottom_20 "></div>
			<div class="header_01">Категории</div>
			<div class="ulcategory"></div>
			<div class="margin_bottom_10 horizontal_divider"></div>
			<div class="margin_bottom_20"></div>
			<div class="header_01">Поиск товара</div>
			<form action="" method="post" id="formsearch">
				<input type="text" placeholder="По наименованию" size="10" id="searchname" class="inputfield" title="Поиск товара" />
				<div id="textprice">По цене</div>
				<div id="textprice">От</div>
				<span id="contentSlider"></span>
				<div id="slider"></div>
				<div id="textprice">До</div>
				<span id="contentSliderTo"></span>
				<div id="sliderTo"></div>
				<p><input type="submit" value="Найти" id="search_button" /></p>
				<p><div id="texterror"></div></p>
			</form>
			<p><div id="texterror"></div></p>
			<div class="margin_bottom_20"></div>
		</td>
	</tr>
</table>