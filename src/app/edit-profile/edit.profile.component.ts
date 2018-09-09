import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params, Router} from "@angular/router";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {Status} from "../shared/interfaces/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {JwtHelperService} from "@auth0/angular-jwt";

declare var $: any;

@Component({
	template: require("./edit.profile.component.html")
})

export class EditProfileComponent implements OnInit {

	editProfileForm: FormGroup;
	profile: Profile = new class implements Profile {
		profileActivationToken: number = null;
		profileAtHandle: string = null;
		profileEmail: string = null;
		profileHash: string = null;
		profileId: string = null;
	};

	status: Status = null;
	cloudinarySecureUrl: string;

	constructor(private formBuilder: FormBuilder, private jwtHelperService: JwtHelperService, private profileService: ProfileService, private route: ActivatedRoute,) {
	}

	ngOnInit(): void {
		let profileToken = this.jwtHelperService.decodeToken(localStorage.getItem("jwt-token"));
		let profileId = profileToken.auth.profileId;
		this.profileService.getProfile(profileId)
			.subscribe(user => {
				this.editProfile = profileId;
				this.editProfileForm.patchValue(this.editProfile);
			});

		this.editProfileForm = this.formBuilder.group({
			profileAtHandle: ["", [Validators.maxLength(32), Validators.required]],
			profileEmail: ["", [Validators.maxLength(128), Validators.required]],
		});

		this.applyFormChanges();
	}

	applyFormChanges(): void {
		this.editProfileForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.profile[field] = values[field];
			}
		});
	}

	editProfile(): void {
		this.profileService.editProfile(this.profile)
			.subscribe(status => this.status = status);
	}

	onCloudinarySecureUrlChange(newCloudinarySecureUrl: string): void {
		this.cloudinarySecureUrl = newCloudinarySecureUrl;
		this.editProfile();
	}
}