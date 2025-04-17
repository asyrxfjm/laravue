declare namespace App.Http.DTOs {
    export type RoleData = {
        name: string;
        id: number | null;
        guard_name: string | null;
        created_at: string | null;
        updated_at: string | null;
        users: Array<App.Http.DTOs.UserData> | null;
    };
    export type UserData = {
        id: number | null;
        name: string;
        email: string;
        avatar: string | null;
        workos_id: string | null;
        created_at: string | null;
        updated_at: string | null;
        roles: Array<App.Http.DTOs.RoleData> | null;
    };
}
