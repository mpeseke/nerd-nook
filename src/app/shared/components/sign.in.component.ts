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

			console.log(status.status);

			if(this.status.status === 200) {
				this.router.navigate(["/landing-page"]);

			} else {
				alert("Email or Password is incorrect. Try again.")
			}
		});
	}
}