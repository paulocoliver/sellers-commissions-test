import {Component, Inject, OnInit} from '@angular/core';
import {Seller} from '../../_models/seller';
import {AppLoaderService} from '../../_services/app-loader.service';
import {AlertService} from '../../_services/alert.service';
import {MAT_DIALOG_DATA, MatDialogRef} from '@angular/material';
import {Sales} from '../../_models/sales';
import {SalesService} from '../../_services/sales.service';

export interface dataSalesCreateComponent {
    seller: Seller;
    onSaved(sale: Sales);
}

@Component({
    selector: 'app-create',
    templateUrl: './create.component.html',
    styleUrls: ['./create.component.scss']
})
export class CreateComponent implements OnInit {

    seller: Seller;
    sale: Sales;

    constructor(
        private salesService: SalesService,
        private appLoaderService: AppLoaderService,
        private alertService: AlertService,
        public dialogRef: MatDialogRef<CreateComponent>,
        @Inject(MAT_DIALOG_DATA) public dataDialog: dataSalesCreateComponent) {

        this.seller = dataDialog.seller;

        this.sale = new Sales();
        this.sale.seller_id = this.seller.id;
    }

    save(): void {

        this.appLoaderService.startLoading();
        this.salesService
            .create(this.sale)
            .subscribe(
                (sale: Sales) => {
                    this.appLoaderService.stopLoading();
                    this.alertService
                        .success('Criado com sucesso')
                        .then(() => {
                            this.dialogRef.close();
                            this.dataDialog.onSaved(sale);
                        });
                },
                () => {
                    this.appLoaderService.stopLoading();
                }
            )
    }


    ngOnInit() {
    }

}
