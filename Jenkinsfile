pipeline {
  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
  }

  environment {
    NAMESPACE = 'crud'
  }

  stages {

    stage('Checkout SCM') {
      steps {
        checkout scm
      }
    }

    stage('Test Database') {
      steps {
        container('kubectl') {
          script {
            echo 'Проверяем доступ к базе данных...'
            // Проверяем, что порт 3306 сервиса mysql-master доступен
            sh """
              timeout 5 bash -c 'echo > /dev/tcp/$(kubectl get svc mysql-master -n ${NAMESPACE} -o jsonpath="{.spec.clusterIP}")/3306'
            """
          }
        }
      }
    }

    stage('Test Frontend') {
      steps {
        container('kubectl') {
          script {
            echo 'Проверяем доступ к frontend...'
            // Здесь проверяем, что порт 8080 сервиса crudback-service доступен
            sh """
              timeout 5 bash -c 'echo > /dev/tcp/$(kubectl get svc crudback-service -n ${NAMESPACE} -o jsonpath="{.spec.clusterIP}")/8080'
            """
          }
        }
      }
    }

    stage('Deploy App to Kubernetes') {
      steps {
        container('kubectl') {
          withCredentials([file(credentialsId: 'kubeconfig-secret-id', variable: 'KUBECONFIG')]) {
            sh 'kubectl create ns crud || true'
            sh 'kubectl apply -f ./manifests -n crud'
          }
        }
      }
    }

  }
}
