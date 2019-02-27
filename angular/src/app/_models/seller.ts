import {Model} from './model';

export class Seller extends Model {
    id: number;
    name: string;
    email: string;
    commissions: number;
    created_at: string;
    updated_at: string;

    attrsToSave(): object {
        return {
            id: this.id,
            name: this.name,
            email: this.email,
        };
    }

    get commission() {
        return this.commissions || 0;
    }
}