pipeline {

  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
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
            // Используем kubectl для проверки pod MySQL
            sh '''
              POD=$(kubectl get pods -n crud -l app=mysql-master -o jsonpath="{.items[0].metadata.name}")
              kubectl exec -n crud $POD -- mysqladmin ping -uroot -psecret
            '''
          }
        }
      }
    }

    stage('Test Frontend') {
      steps {
        container('kubectl') {
          script {
            echo 'Проверяем доступ к фронтенду...'
            sh '''
              SERVICE_IP=$(kubectl get svc crudback-service -n crud -o jsonpath="{.spec.clusterIP}")
              curl -s --head http://$SERVICE_IP:8080 | head -n 1
            '''
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
