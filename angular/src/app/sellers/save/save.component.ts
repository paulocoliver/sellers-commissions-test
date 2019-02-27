import {Component, Inject, OnInit} from '@angular/core';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material';
import {SellersService} from '../../_services/sellers.service';
import {Seller} from '../../_models/seller';
import {AppLoaderService} from '../../_services/app-loader.service';
import {AlertService} from '../../_services/alert.service';

export interface dataSaveComponent {
    seller: Seller;
    onSaved(seller: Seller);
    onDeleted(seller: Seller);
}

@Component({
  selector: 'app-modal',
  templateUrl: './save.component.html',
  styleUrls: ['./save.component.scss']
})
export class SaveComponent implements OnInit {

    seller: Seller;

    constructor(
        private sellersService: SellersService,
        private appLoaderService: AppLoaderService,
        private alertService: AlertService,
        public dialogRef: MatDialogRef<SaveComponent>,
        @Inject(MAT_DIALOG_DATA) public dataDialog: dataSaveComponent) {

        this.seller = dataDialog.seller;
    }

    save(): void {

        this.appLoaderService.startLoading();

        let request;
        let msg;
        if (this.seller.isSaved) {
            request = this.sellersService.update(this.seller);
            msg = 'Alterado com sucesso';
        } else {
            request = this.sellersService.create(this.seller);
            msg = 'Criado com sucesso';
        }

        request.subscribe(
            (seller) => {
                this.appLoaderService.stopLoading();
                this.alertService
                    .success(msg)
                    .then(() => {
                        this.dialogRef.close();
                        this.dataDialog.onSaved(seller);
                    });
            },
            () => {
                this.appLoaderService.stopLoading();
            }
        )
    }

    delete(seller: Seller) {
        this.alertService.confirm("Apagar vendedor?")
            .then(
                () => {
                    this.appLoaderService.startLoading();
                    this.sellersService.delete(seller)
                        .subscribe(
                            () => {
                                this.appLoaderService.stopLoading();
                                this.alertService
                                    .success('Apagado com sucesso')
                                    .then(() => {
                                        this.dialogRef.close();
                                        this.dataDialog.onDeleted(seller);
                                    });
                            },
                            () => {
                                this.appLoaderService.stopLoading();
                            }
                        );
                },
                ()=>{}
            );
    }

    ngOnInit() {
    }

}
