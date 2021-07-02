# Hackathon 3 Amigos

This project assumes you have an existing [k8ssandra](https://k8ssandra.io/) cluster where you are able to apply the deployment.yamls.
One could deploy without k8ssandra providing some basic changes to env passed to the deployments.

My testing environment is a k3d cluster running k8ssanrda.  I also have a GK3 cluster running k8ssandra.

If you are using k3ds here are the commands to get started.

```
git clone https://github.com/ds-steven-matison/hackathon-3-amigos.git
cd hackathon-3-amigos.git
k3d cluster create
helm install -f k8ssandra.yaml k8ssandra k8ssandra/k8ssandra
watch kubectl get pods
```
:warning:  Make sure you have already completed all of the environment setups per [k8ssandra documentation](https://docs.k8ssandra.io/install/local/#prerequisites).

## User and pass needed for local testing

```
kubectl get secret k8ssandra-superuser -o jsonpath="{.data.username}" | base64 --decode ; echo
kubectl get secret k8ssandra-superuser -o jsonpath="{.data.password}" | base64 --decode ; echo
```

## Port forwarding for local access

```
kubectl port-forward svc/k8ssandra-dc1-stargate-service 8080 8081 8082 9042
```

## Use cqlsh to load project.cql statements

```
kubectl exec -it k8ssandra-dc1-default-sts-0 -- bash -c "wget https://raw.githubusercontent.com/ds-steven-matison/hackathon-3-amigos/main/project.cql -P /tmp && /opt/cassandra/bin/cqlsh localhost 9042 -u k8ssandra-superuser -p [pass above] -f /tmp/project.cql"
```

## Deploy the project application

```
kubectl apply -f deployment.k8s.yaml
```

## Create your own dockerhub image

You are able to use this project's dockerhub image if you do not want to change the deployment.  If you are changing the app, please
follow these directions to create your own image, and put the docker build/push steps into your dev cycle to reset the app as you iterate app changes.

Current Docker [image](https://hub.docker.com/repository/docker/dsstevenmatison/tres-amigos). 

1. Git clone [this repo]
2. Next build and push image
```
docker build . -t dsstevenmatison/tres-amigos
docker push dsstevenmatison/tres-amigos
```
:warning: This sample above is mine, you would change to your dockerhubrepo/appname.  Then in the deployment.k8s.yaml file you reference the full docker.io string to image.  For example: <b></i>docker.io/dsstevenmatison/tres-amigos:latest</i></b>.

3. Edit deployment.k8s.yaml accordingly then
```
kubectl apply -f deployment.k8s.yaml
```
4. If you are just updating the image, murder the pod and it will recreate w/ new image
```
kubectl delete pod tres-amigos-6c6cd5c6d6-qlxhb
```
:bulb: Monitor your <b></i>watch kubectl get pods</i></b> terminal and watch this pod terminate and recreate!!!

## Access app locally

```
kubectl port-forward deployments/tres-amigos  1337:80
```
After port fwd access app @ [http://localhost:1337](http://localhost:1337).

## Connect to app container

```
kubectl exec -it deployments/tres-amigos /bin/bash
```
:bulb: Use the command <b></i>tail -f /var/log/php5-fpm.log</i></b> to check PHP Errors.  You can also find the app source at <b></i>/usr/share/nginx/html</i></b>.


## Cluster should look like

```
NAME                                                READY   STATUS    RESTARTS   AGE
k8ssandra-kube-prometheus-operator-85695ffb-rx6tj   1/1     Running   0          81m
k8ssandra-reaper-operator-b67dc8cdf-cxntz           1/1     Running   0          81m
prometheus-k8ssandra-kube-prometheus-prometheus-0   2/2     Running   1          81m
k8ssandra-cass-operator-7c876d6d96-ls2pv            1/1     Running   0          81m
k8ssandra-grafana-5c6d5b8f5f-gb2hg                  2/2     Running   0          81m
k8ssandra-dc1-default-sts-0                         2/2     Running   0          80m
k8ssandra-dc1-stargate-77d4985d67-s69xd             1/1     Running   0          81m
k8ssandra-reaper-655fc7dfc6-jcf7p                   1/1     Running   0          76m
tres-amigos-6c6cd5c6d6-hrmsx                        1/1     Running   0          44m
```