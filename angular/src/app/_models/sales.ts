import {Model} from './model';

export class Sales extends Model {
    id: number;
    seller_id: number;
    commission: number;
    amount: number;

    attrsToSave(): object {
        return {
            seller_id: this.seller_id,
            amount: this.amount,
        };
    }
}