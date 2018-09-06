import {Component, ViewChild} from "@angular/core";

import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign.in";
import {SignInService} from "../services/sign.in.service";
import {CookieService} from "ng2-cookies";




@Component ({
	template: require("./sign.in.html"),
	selector: "signin"
})

export class SignInComponent {
	@ViewChild("signInForm") signInForm: any;

	signin: SignIn = {profileEmail: null, profilePassword: null};
	status: Status = {status: null, type: null, message: null};

	constructor(private SignInService: SignInService, private router: Router, private cookieService : CookieService) {
	}



}