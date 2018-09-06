import {Component, ViewChild} from "@angular/core";

import {Router} from "@angular/router";
import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign.in";
import {SignInService} from "../services/sign.in.service";
import {CookieService} from "ng2-cookies";
declare var $: any;


@Component ({
	template: require("./sign.in.component.html"),
	selector: "signin"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = {profileEmail: null, profilePassword: null};
	status: Status = {status: null, type: null, message: null};

	constructor(private SignInService: SignInService, private router: Router, private cookieService : CookieService) {
	}



	signIn(): void {
		localStorage.removeItem("jwt-token");
		this.SignInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;

			if(status.status === 200) {
				this.router.navigate(["profile-page"]); //this will need to be changed to our landing page
				this.signInForm.reset();
				setTimeout(1000, function() {
					$("signin-modal").modal('hide');
				});
			} else {
				console.log("failed login")
			}
		});
	}
}