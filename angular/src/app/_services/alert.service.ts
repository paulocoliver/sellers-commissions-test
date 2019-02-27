import { Injectable } from '@angular/core';

import swal from 'sweetalert2';
import { SweetAlertType } from 'sweetalert2';


/**
 * @see https://limonte.github.io/sweetalert2/
 * */
@Injectable({
  providedIn: 'root'
})
export class AlertService {

    constructor() {
        swal.setDefaults({});
    }


    private show(title: any, message?: string, type?:SweetAlertType): Promise<any> {

        let swalPromise: Promise<any>;

        if (typeof title == 'object' && title != null) {
            title.type = type;
            if(typeof title.title != 'string'){
                title.title = '';
            }
            if(typeof title.text != 'string'){
                title.text = '';
            }
            swalPromise = swal(title);
        } else {
            swalPromise = swal(title ? title : '', message, type);
        }

        return new Promise<any>((resolve: (result?:any) => void, reject: () => void) => {
            swalPromise.then(
                (result:any)  => {
                    if (result.value || !result.dismiss) {
                        resolve(result);
                    }else {
                        reject();
                    }
                },
                () => {
                    reject();
                }
            )
        });
    }

    success(title:any, message?: string): Promise<any> {
        return this.show(title, message, 'success');
    }

    error(title:any, message?: string): Promise<any> {
        return this.show(title, message, 'error');
    }

    warning(title:any, message?: string): Promise<any> {
        return this.show(title, message, 'warning');
    }

    info(title:any, message?: string): Promise<any> {
        return this.show(title, message, 'info');
    }

    question(title:any, message?: string): Promise<any> {
        return this.show(title, message, 'question');
    }

    confirm(title: any, message?: string, type:string ='question'): Promise<any> {
        return this.show({
            title: title,
            text: message,
            type: type,
            showCancelButton: true,
        });
    }

    remove(title:any ='Are you sure?', message:string ="You won't be able to revert this!", html:boolean=false): Promise<any> {

        let obj = {
            title: title,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            html: '',
            text: '',
        };

        if(html){
            obj['html'] = message;
            delete obj['text'];
        }else{
            obj['text'] = message;
            delete obj['html'];
        }
        return this.show(obj);
    }
}