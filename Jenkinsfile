pipeline {
    // This agent definition is correct and creates the multi-container pod
    agent {
        kubernetes {
            yaml """
apiVersion: v1
kind: Pod
spec:
  containers:
  - name: kubectl
    image: bitnami/kubectl:latest
    command:
    - sleep
    args:
    - 99d
"""
        }
    }

    stages {
        // We will run all steps inside the 'kubectl' container
        stage('Checkout') {
            steps {
                container('kubectl') {
                    checkout scm
                }
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                // Explicitly run these steps in the 'kubectl' container
                container('kubectl') {
                    sh 'kubectl apply -f k8s-manifests/'
                    echo 'Развертывание запущено. Ожидание 60 секунд для стабилизации подов...'
                    sleep 60
                }
            }
        }

        stage('Verify Database Connection') {
            steps {
                // Explicitly run these steps in the 'kubectl' container
                container('kubectl') {
                    script {
                        echo "Проверка доступности базы данных..."
                        def appPodName = sh(script: "kubectl get pods -l app=crudback -o jsonpath='{.items[0].metadata.name}'", returnStdout: true).trim()
                        if (appPodName) {
                            sh "kubectl exec -it ${appPodName} -- bash -c \"timeout 10 bash -c '</dev/tcp/db/3306' && echo 'База данных MySQL доступна' || (echo 'Ошибка: база данных MySQL недоступна' && exit 1)\""
                        } else {
                            error "Под приложения не найден."
                        }
                    }
                }
            }
        }

        stage('Verify Frontend Availability') {
            steps {
                // Explicitly run these steps in the 'kubectl' container
                container('kubectl') {
                    script {
                        echo "Проверка доступности веб-приложения..."
                        def externalIp = sh(script: "kubectl get svc crudback-service -o jsonpath='{.status.loadBalancer.ingress[0].ip}'", returnStdout: true).trim()
                        if (externalIp) {
                            echo "Приложение доступно по адресу: http://${externalIp}"
                            // Use a temporary pod with curl to perform the check
                            sh "kubectl run curl-test --image=curlimages/curl:latest --rm -it --restart=Never -- curl --fail --connect-timeout 5 --silent http://${externalIp} || (echo 'Ошибка: веб-приложение недоступно по внешнему IP' && exit 1)"
                        } else {
                            error "Внешний IP для сервиса crudback-service не найден."
                        }
                    }
                }
            }
        }
    }
    post {
        always {
            // Clean up the test pod if it exists
            container('kubectl') {
                sh 'kubectl delete pod curl-test --ignore-not-found'
            }
        }
        success {
            echo 'Сборка успешно завершена!'
        }
        failure {
            echo 'Сборка провалена.'
        }
    }
}
