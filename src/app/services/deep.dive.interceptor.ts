import {Injectable} from "@angular/core";
import {HttpEvent, HttpInterceptor, HttpRequest, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs";

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
}
