package bg.uni_sofia.fmi.spo.calculate_E;

import java.io.BufferedWriter;
import java.io.FileWriter;
import java.io.IOException;
import java.util.Calendar;

import org.apfloat.Apfloat;


public class CalculateE {
	
	public void calculate (int precision, int numberOfThreads, String filename, boolean quiet){

		if(!quiet){
        	System.out.println("Starting calculation");
        }
		long startTime = Calendar.getInstance().getTimeInMillis();
		CalculateETask[] threads = new CalculateETask[numberOfThreads];
		boolean calculated = false;
		int currentTerm = 0;
		

		Apfloat oldSum = new Apfloat(0.0, precision);
		Apfloat sum = new Apfloat(0.0, precision);
		while (!calculated){

			for (int i = 0; i < numberOfThreads; i++){
				threads[i] = new CalculateETask(precision, currentTerm, currentTerm + 99, quiet);
				currentTerm += 100;
			}
			for (int i = 0; i < numberOfThreads; i++){
				threads[i].start();
			}
			for (int i = 0; i < numberOfThreads; i++){
				try {
					threads[i].join();
				} catch (InterruptedException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
				sum = sum.add(threads[i].sum);
			}

			if (numberOfThreads > 1 && threads[numberOfThreads-1].lastTerm.scale() < (0 - precision)){
				calculated = true;
				if(!quiet){
		        	System.out.println("Threads finished. Calculated values are precise.");
		        }
			}
			else if (sum.equals(oldSum)){
				calculated = true;
				if(!quiet){
		        	System.out.println("Threads finished. Calculated values are precise.");
		        }
			}
			else{
				oldSum = sum;
				if(!quiet){
		        	System.out.println("Threads finished. Calculated values are not precise.");
		        }
			}
		}
		long endTime = Calendar.getInstance().getTimeInMillis();
        long calculationTime = endTime - startTime;
    	System.out.println("Calculation time:" + calculationTime);
        if(!quiet){
        	System.out.println("Writing to file");
        }
        String calculatedValue = sum.toString();
        try (BufferedWriter bw = new BufferedWriter(new FileWriter(filename))){
        	bw.write(calculatedValue);        	
        } catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
        if(!quiet){
        	System.out.println("Calculated value of E:" + calculatedValue);
        }
	}
}