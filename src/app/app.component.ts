import {Component} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";

@Component({
	selector: "nerd-nook-app",
	template: require("./app.component.html"),
})

export class AppComponent {
	status : Status = null;

	constructor(protected sessionService : SessionService) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}
}