import {Component} from "@angular/core";
import {Status} from "../../interfaces/status";
import {SignInService} from "../../services/sign.in.service";
import {Router} from "@angular/router";


@Component({
	selector:"nav-bar",
	template: require ("./nav-bar.component.html")
})

export class NavBarComponent {
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router) {}

	signOut() : void {
	localStorage.clear();
this.signInService.signOut().subscribe(status=>this.status=status);
window.location.replace("");
}}
