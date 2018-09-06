import {Component} from "@angular/core";
import {Status} from "../../interfaces/status";
import {SignInService} from "../../services/sign.in.service";

@Component({
	selector:"nav-bar",
	template: require ("./nav-bar.component.html")
})

export class NavBarComponent {
	status: Status = null;

	constructor(private signInService: SignInService) {}
		signOut() : void{
			this.signInService.signOut();
		}
	}