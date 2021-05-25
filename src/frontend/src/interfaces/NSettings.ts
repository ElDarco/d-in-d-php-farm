interface NSettings extends NObject {
    id: string;
    uri: string;
    method: string;
    queryString: string;
    responseBody: string;
    responseCode: number;
    headers: [];
}