interface NRequest extends NObject {
    id: string;
    uri: string;
    method: string;
    queryString: string;
    body: string;
    createdAt: string;
    proxyResponse: NProxyResponse|[];
}