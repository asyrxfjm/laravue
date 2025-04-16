declare namespace App.Http.DTOs {
    export type UserData = {
        id: number;
        name: string;
        email: string;
        avatar?: string;
        workos_id: string | null;
        created_at: string | null;
        updated_at: string | null;
    };
}
