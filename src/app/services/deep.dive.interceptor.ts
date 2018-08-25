import {Injectable} from "@angular/core";
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs";
import {map} from "rxjs/operators";

/**
 * class that intercepts data for Deep Dives' API standard
 *
 * All API's in Deep Dive return an object with three state variables:
 * 1. Status: (int, required): 200 if successful and any other int if not.
 * 2. Data: (any, optional): result of a GET request
 * 3. Message: (string, optional): status message result of a non GET request.
 *
 * this interceptor will use the HttpResponse to return either the data of the status message.
 */

@Injectable()
export class DeepDiveInterceptor implements HttpInterceptor {
	/**
	 * intercept method that extracts the data or status message on standards outlined above
	 *
	 * @param {HttpRequest<any>} request incoming HTTP request
	 * @param {HttpHandler} next outgoing handler for next interceptor
	 * @returns {Observable<HttpRequest<any>>} Observable for next interceptor to subscribe to
	 */
	intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		//hand off to next interceptor
		return(next.handle(request).pipe(map((event:HttpEvent<any>) => {
			//if this is an HTTP Response, from Angular...
			if(event instanceof HttpResponse && event.body ==! null) {
				//create an event to return (by default, return the same event)
				let dataEvent = event;

				//if the API is successful...
				if(event.status === 200) {
					//extract the JWT Header and put it in local storage
					if(localStorage.getItem("jwt-token") === null) {
						let jwtToken = event.headers.getAll("X-JWT-TOKEN");

						if(jwtToken !== null) {
							let token : string = jwtToken[0];
							console.log(token);
							localStorage.setItem("jwt-token", token.toString());
						}
					}
					//extract the data or message from the response body
					let body= event.body;
					if(body.status === 200) {
						if(body.data) {
							//extract data returned from a GET request
							dataEvent = event.clone({body: body.data});
						} else if(body.message) {
							//extract a successful message
							dataEvent = event.clone({body: {message: body.message, status: 200, type: "alert-success"}});
						}
					} else {
						//extract a failing message when the API fails
						dataEvent = event.clone({body: {message: body.message, status: body.status, type: "alert-danger"}});
					}
				} else {
					//extract a failing message when the web server fails
					dataEvent = event.clone({body: {message: event.statusText, status: event.status, type: "alert-danger"}});
				}
				return(dataEvent);
			}
		})))
	}
}
