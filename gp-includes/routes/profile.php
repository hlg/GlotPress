<?php
class GP_Route_Profile extends GP_Route_Main {
	function profile_get() {
		if ( !GP::$user->logged_in() ) {
			$this->redirect( gp_url( '/login?redirect_to=' ).urlencode( gp_url( '/profile') ) );
			return;
		}

		$this->tmpl( 'profile' );
	}

	function profile_post() {
		if ( isset( $_POST['submit'] ) ) {

			$newPass = $_POST['pass'];
			$newPassRep = $_POST['passrep'];
			if($newPass!=''){
				if($newPass!=$newPassRep){
					$this->errors[] = __("Passwords do not match!");
				} else {
					$current = GP::$user->current();
					$current->set_password( $newPass );
					$current->logout();
					$current = GP::$user->by_login($current->user_login);
					$current->login($newPass);
					$this->notices[] = __("Password changed.");
				}
			}
			$per_page = (int) $_POST['per_page'];
			GP::$user->current()->set_meta( 'per_page', $per_page );

			$default_sort = $_POST['default_sort'];
			GP::$user->current()->set_meta( 'default_sort', $default_sort );
		}

		$this->redirect( gp_url( '/profile' ) );
	}
}
