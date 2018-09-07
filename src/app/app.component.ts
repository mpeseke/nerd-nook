import {Component} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";

@Component({
	selector: "nerd-nook-app",
	template: require("./app.component.html"),
})

export class AppComponent {
	status : Status = null;

	constructor(protected sessionService : SessionService, private signInService : SignInService) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}

	signOut() : void {
		localStorage.clear();
		this.signInService.signOut().subscribe(status=>this.status=status);
		window.location.replace("/signin");
	}
}