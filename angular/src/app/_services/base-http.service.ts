import { Injectable } from '@angular/core';
import {HttpClient, HttpErrorResponse, HttpHeaders} from '@angular/common/http';
import {Observable, throwError} from 'rxjs';
import {catchError, map} from 'rxjs/operators';
import {Model} from '../_models/model';
import {AlertService} from './alert.service';

export abstract class BaseHttpService {

    private urlBase = 'http://0.0.0.0:3333/api';
    protected abstract resource;

    constructor(protected http: HttpClient, protected alertService: AlertService) { }

    private defaultHttpOptions() {
        return {
            headers: new HttpHeaders({ 'Content-Type': 'application/json' })
        };
    }

    onError401(error: any): void{}

    onError403(error: any): void{}

    toSwalFormat(res: any) {
        let html = '';
        if (res.messages) {
            let li = '';
            for (var index in res.messages) {
                li += `<li>` + res.messages[index] + `</li>`;
            }
            html = `<ul style="list-style: none">` + li + `</ul>`;
        }

        return {
            title: res.error,
            type: 'error',
            html: html,
            showCloseButton: true,
        };
    }

    private handleError() {
        return (err: any) => {
            if (err instanceof HttpErrorResponse) {
                if (err.status == 401) {
                    this.onError401(err);

                } else if(err.status == 403) {
                    this.onError403(err);
                } else {
                    this.alertService
                        .error(
                            this.toSwalFormat(err.error)
                        )
                        .then(
                            () => {},
                            () => {}
                        );
                }
            }
            return throwError(err);
        }
    }


    get urlResorce() {
        return `${this.urlBase}/${this.resource}`;
    }

    protected abstract createModel(item): Model;

    list (params?): Observable<Model[]> {
        let httpOptions = this.defaultHttpOptions();
        httpOptions['params'] = params;
        return this.http
            .get<Model[]>(this.urlResorce, httpOptions)
            .pipe(
                map(response => {
                    let result = [];
                    response['data'].forEach((item: any) => {
                        result.push(this.createModel(item));
                    });
                    response['data'] = result;
                    return response;
                }),
                catchError(this.handleError())
            )
    }

    create (model: Model): Observable<Model> {
        let httpOptions = this.defaultHttpOptions();

        return this.http
            .post<Model[]>(this.urlResorce, model.attrsToSave(), httpOptions)
            .pipe(
                map(response => {
                    return this.createModel(response);
                }),
                catchError(this.handleError())
            )

    }

    update (model: Model): Observable<Model> {
        let httpOptions = this.defaultHttpOptions();

        return this.http
            .put<Model[]>(`${this.urlResorce}/${model.getKey()}`, model.attrsToSave(), httpOptions)
            .pipe(
                map(response => {
                    return this.createModel(response);
                }),
                catchError(this.handleError())
            )
    }

    delete (model: Model): Observable<any> {
        let httpOptions = this.defaultHttpOptions();
        return this.http
            .delete(`${this.urlResorce}/${model.getKey()}`, httpOptions)
            .pipe(
                catchError(this.handleError())
            );
    }
}
