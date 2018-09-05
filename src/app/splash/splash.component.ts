import {Component, OnInit} from "@angular/core";
import {Observable} from "rxjs";
import {Router} from "@angular/router";
import {Status} from "../shared/interfaces/status";
import {SignUp} from "../shared/interfaces/sign.up";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {SignUpService} from "../shared/services/sign.up.service";
import {SignIn} from "../shared/interfaces/sign.in";


//declare $ for use of jQuery
declare let $: any;

//set the template url and the selector for the ng powered html tag

@Component({
	template: require
	("./splash.template.html"),
	selector: "sign-up"
})

export class SplashComponent implements OnInit {

	signUpForm: FormGroup;
	status: Status = {status: null, message: null, type: null};

	constructor(private formBuilder: FormBuilder, private router: Router, private signUpService: SignUpService) {
	}

	ngOnInit(): void {
		this.signUpForm = this.formBuilder.group({
			profileAtHandle: ["", [Validators.maxLength(32), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required, Validators.email]],
			profilePassword: ["", [Validators.minLength(8), Validators.maxLength(48), Validators.required]],
			profilePasswordConfirm: ["", [Validators.minLength(8), Validators.maxLength(48), Validators.required]]
		});

		this.status = {status: null, message: null, type: null}


	}

	createSignUp(): void {

		let signUp: SignUp = {
			profileAtHandle: this.signUpForm.value.atHandle,
			profileEmail: this.signUpForm.value.email,
			profilePassword: this.signUpForm.value.password,
			profilePasswordConfirm: this.signUpForm.value.passwordConfirm
		};

		this.signUpService.createProfile(signUp)
			.subscribe(status => {
				this.status = status;

				if(this.status.status === 200) {
					this.router.navigate([""])
				}
			});
	}
}
